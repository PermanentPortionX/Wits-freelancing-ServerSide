<?php
    header('Access-Control-Allow-Origin: *');
    require_once("WitsFreelanceDatabaseManager.php");
    require_once("BusinessManager.php");
    require_once("NotificationManager.php");

    $db = new WitsFreelanceDatabaseManager();
    $bm = new BusinessManager();
    $nm = new NotificationManager();

    $ACTION = $_REQUEST[Constants::ACTION];

    switch ($ACTION){
        //1627982.ms.wits.ac.za/~student/Job.php?ACTION=0&JOB_EMPLOYER_ID=1627982&JOB_TITLE=test&JOB_DESCRIPTION=description_here&JOB_AMOUNT_RANGE_LOW=0&JOB_AMOUNT_RANGE_HIGH=100&JOB_DUE_DATE_TIME=10/12/2012_19:20&JOB_LOCATION=location&JOB_CATEGORY=0
        case Constants::POST:
            $stmt = "INSERT INTO ".Constants::JOB_TABLE." (".Constants::JOB_ID.",".Constants::JOB_EMPLOYER_ID.",".Constants::JOB_TITLE.","
                .Constants::JOB_DESCRIPTION.",".Constants::JOB_POST_DATE_TIME.",".Constants::JOB_AMOUNT_RANGE_LOW.",".Constants::JOB_AMOUNT_RANGE_HIGH.","
                .Constants::JOB_STATUS.",".Constants::JOB_DUE_DATE_TIME.",".Constants::JOB_LOCATION.",".Constants::JOB_CATEGORY.
            ") VALUES(0, :JEI, :JT, :JDESC, :JPDT, :JARL, :JARH, :JS, :JDD, :JL, :JC)";

            $args = array(
                "JEI" => $_REQUEST[Constants::JOB_EMPLOYER_ID],
                "JT" => $_REQUEST[Constants::JOB_TITLE],
                "JDESC" => $_REQUEST[Constants::JOB_DESCRIPTION],
                "JPDT" => date(Constants::DATE_TIME_FORMAT),
                "JARL" => $_REQUEST[Constants::JOB_AMOUNT_RANGE_LOW],
                "JARH" => $_REQUEST[Constants::JOB_AMOUNT_RANGE_HIGH],
                "JS" => Constants::OPEN,
                "JDD" => $_REQUEST[Constants::JOB_DUE_DATE_TIME],
                "JL" => $_REQUEST[Constants::JOB_LOCATION],
                "JC" => $_REQUEST[Constants::JOB_CATEGORY]
            );

            if ($bm -> hasEnoughFunds($args["JEI"], $args["JARH"])) {
                $jobId = $db -> execute($stmt, $args, true);

                $transactionId = $bm -> performTransaction($args["JEI"], -1*$args["JARH"],"Reserved for job post");
                $bm -> performTransaction($args["JEI"], -1 * $args["JARH"] * Constants::TRANSACTION_FEE, "Job Post fee");

                $stmt = "UPDATE ".Constants::JOB_TABLE." SET ".Constants::TRANSACTION_ID." = :TID WHERE ".Constants::JOB_ID." = :JID";
                $args = array("TID" => $transactionId, "JID" => $jobId);
                $db -> execute($stmt, $args, false);
            }
            else $bm -> sendInsufficientFundsError();

            break;

        case Constants::VIEW_ALL:
            $stmt = "SELECT * FROM ".Constants::JOB_TABLE." WHERE ".Constants::JOB_STATUS." = ".Constants::OPEN;
            $execStmt = $db -> getPdo() -> prepare($stmt);
            if ($execStmt -> execute(array())){
                $results = array();

                while ($row = $execStmt -> fetch(PDO::FETCH_ASSOC)){
                    $jobId = $row[Constants::JOB_ID];
                    $stmt = "SELECT COUNT(*) AS NUM_OF_BIDS FROM ".Constants::BID_TABLE." WHERE ".Constants::JOB_ID." = :ID";
                    $stmt = $db -> getPdo() -> prepare($stmt);
                    if ($stmt -> execute(array("ID" => $jobId))){
                        $row["NUM_OF_BIDS"] = $stmt -> fetch(PDO::FETCH_ASSOC)["NUM_OF_BIDS"];
                    }
                    else{
                        $row["NUM_OF_BIDS"] = 0;
                    }
                    $results[] = $row;
                }
                echo json_encode($results);
            }
            else echo json_encode(Constants::DEFAULT_JSON_ARRAY);

            break;

        case Constants::ASSIGN_JOB:
            $stmt = "UPDATE ".Constants::JOB_TABLE." SET ".Constants::JOB_STATUS." = ".Constants::ASSIGNED.", ".Constants::JOB_EMPLOYEE_ID
                ." = :EID WHERE ".Constants::JOB_ID." = :JID";
            $stmt = $db -> getPdo() -> prepare($stmt);
            $recipientId = $_REQUEST[Constants::JOB_EMPLOYEE_ID];
            $jobId = $_REQUEST[Constants::JOB_ID];
            if($stmt -> execute(array("EID" => $recipientId, "JID" => $jobId))){
                //retrieve job title
                $fetchJob = "SELECT ".Constants::JOB_TITLE." FROM ".Constants::JOB_TABLE." WHERE ".Constants::JOB_ID." = ".$jobId;
                $fetchJob = $db -> getPdo() -> prepare($fetchJob);
                $fetchJob -> execute(array());
                $jobTitle = $fetchJob -> fetch(PDO::FETCH_ASSOC)[Constants::JOB_TITLE];

                //TODO: send notification to recipient
                $message = "Dear ".$recipientId.", We are glad to notify you that the job titled \"".$jobTitle."\" that you bidded for, has been assigned to you";
                $nm -> sendNotification($recipientId, $message, "Job bid successful");

                echo Constants::SUCCESS;
            }
            else echo Constants::FAILED;
            //$db -> execute($stmt, array("EID" => $_REQUEST[Constants::JOB_EMPLOYEE_ID], "JID" => $_REQUEST[Constants::JOB_ID]), true);
            break;


        case Constants::PAY:
            $stmt = "SELECT * FROM ".Constants::JOB_TABLE." WHERE ".Constants::JOB_ID." = :JID AND ".Constants::JOB_STATUS." = ".Constants::COMPLETE;
            $args = array("JID" => $_REQUEST[Constants::JOB_ID]);
            if ($db -> exists($stmt, $args)){
                $stmt = $db -> getPdo() -> prepare($stmt);
                if($stmt -> execute($args)){
                    $returnedRow = $stmt -> fetch(PDO::FETCH_ASSOC);
                    $employeeId = $returnedRow[Constants::JOB_EMPLOYEE_ID];
                    $jobId = $returnedRow[Constants::JOB_ID];
                    $jobTitle = $returnedRow[Constants::JOB_TITLE];
                    $employerId = $returnedRow[Constants::JOB_EMPLOYER_ID];
                    $employerAmount = $returnedRow[Constants::JOB_AMOUNT_RANGE_HIGH];


                    $stmt = "SELECT ".Constants::BID_SUGGESTED_AMOUNT." FROM ".Constants::BID_TABLE." WHERE ".Constants::JOB_ID
                        ." = :JID AND ".Constants::BIDDER_ID." = :BID";
                    $args = array("JID" => $jobId, "BID" => $employeeId);

                    $stmt = $db -> getPdo() -> prepare($stmt);
                    if ($stmt -> execute($args)){
                        $returnedRow = $stmt -> fetch(PDO::FETCH_ASSOC);
                        $employeeAmount = $returnedRow[Constants::BID_SUGGESTED_AMOUNT];
                        $transactionFee = $employeeAmount * Constants::TRANSACTION_FEE;
                        $total = $employeeAmount - $transactionFee;
                        $employerAmount *= -1;

                        $reason = "Payment by ".$employerId." for job titled \"".$jobTitle."\"";

                        if ($bm -> performTransaction($employeeId, $employeeAmount, $reason) != -1){
                            $transactionFee *= -1;
                            $transReason = "Transaction fee";
                            $bm -> performTransaction($employeeId, $transactionFee, $transReason);
                            //TODO: send notification to both users
                            $nm -> sendReceipt($employeeId, $employeeAmount, $transactionFee, $total, $employerId, $jobTitle);
                            echo Constants::SUCCESS;

                            $stmt = "UPDATE ".Constants::JOB_TABLE." SET ".Constants::JOB_STATUS." = "
                                .Constants::PAID." WHERE ".Constants::JOB_ID." = :JID";
                            $db -> execute($stmt, array("JID" => $jobId), false);

                            $employerAmount = abs($employerAmount) - abs($employeeAmount);
                            
                            if ($employerAmount > 0){
                                $reason = "remaining amount from job titled \"".$jobTitle."\" payment to ".$employeeId;
                                $bm -> performTransaction($employerId, $employerAmount, $reason);
                                $message = "Hello ".$employerId.", payment to ".$employeeId." was a success for job titled ".$jobTitle.", since the agreed salary was "
                                    .$employeeAmount." and your highest amount you were willing to pay was ".$returnedRow[Constants::JOB_AMOUNT_RANGE_HIGH].", your change is "
                                    .$employerAmount;
                                $nm -> sendNotification($employerId, $message, "payment to ".$employeeId." was a success");
                            }
                            else{
                                //TODO: send notification that payment was a success
                                $message = "Hello ".$employerId.", payment to ".$employeeId." was a success for job titled ".$jobTitle.", total payment is ".$employeeAmount;
                                $nm -> sendNotification($employerId, $message, "payment to ".$employeeId." was a success");
                            }
                        }
                    }
                    else echo Constants::FAILED;
                }
                else echo Constants::FAILED;
            }
            else echo Constants::FAILED;
            break;


        case Constants::JOB_COMPLETE:
            $stmt = "UPDATE ".Constants::JOB_TABLE." SET ".Constants::JOB_STATUS." = "
                .Constants::COMPLETE." WHERE ".Constants::JOB_ID." = :JID";
            $args = array("JID" => $_REQUEST[Constants::JOB_ID]);
            //$db -> execute($stmt, array("JID" => $_REQUEST[Constants::JOB_ID]), true);
            $stmt = $db -> getPdo() -> prepare($stmt);
            if ($stmt -> execute($args)){
                $stmt = "SELECT * FROM ".Constants::JOB_TABLE." WHERE ".Constants::JOB_ID." = :JID";
                $stmt = $db -> getPdo() -> prepare($stmt);
                if ($stmt -> execute($args)){
                    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
                    $employerId = $row[Constants::JOB_EMPLOYER_ID];
                    $employeeId = $row[Constants::JOB_EMPLOYEE_ID];
                    $jobTitle = $row[Constants::JOB_TITLE];
                    $message = "Hello ".$employerId.", this email is to notify you that ".$employeeId." has completed the job titled \"".$jobTitle;
                    $nm -> sendNotification($employerId, $message, "Job completion");
                    //TODO: send notification to employer that job is completed
                    echo Constants::SUCCESS;
                }
                else echo Constants::FAILED;
            }
            else echo Constants::FAILED;

            break;


        case Constants::VIEW_MY_JOBS:
            $myId = $_REQUEST[Constants::JOB_EMPLOYER_ID];
            $stmt = "SELECT * FROM ".Constants::JOB_TABLE." WHERE ".Constants::JOB_EMPLOYER_ID." = :ID ORDER BY ".Constants::JOB_STATUS." ASC";
            $execStmt = $db -> getPdo() -> prepare($stmt);
            if ($execStmt -> execute(array("ID" => $myId))){
                $results = array();

                while ($row = $execStmt -> fetch(PDO::FETCH_ASSOC)){
                    $jobId = $row[Constants::JOB_ID];
                    $stmt = "SELECT COUNT(*) AS NUM_OF_BIDS FROM ".Constants::BID_TABLE." WHERE ".Constants::JOB_ID." = :ID";
                    $stmt = $db -> getPdo() -> prepare($stmt);
                    if ($stmt -> execute(array("ID" => $jobId))){
                        $row["NUM_OF_BIDS"] = $stmt -> fetch(PDO::FETCH_ASSOC)["NUM_OF_BIDS"];
                    }
                    else{
                        $row["NUM_OF_BIDS"] = 0;
                    }
                    $results[] = $row;
                }
                echo json_encode($results);
            }
            else echo json_encode(Constants::DEFAULT_JSON_ARRAY);
            //$db -> fetch($stmt, array("ID" => $myId));
            break;

        case Constants::VIEW_MY_OFFERED_JOBS:
            $myId = $_REQUEST[Constants::JOB_EMPLOYEE_ID];
            $stmt = "SELECT * FROM ".Constants::JOB_TABLE." WHERE ".Constants::JOB_EMPLOYEE_ID." = :ID ORDER BY ".Constants::JOB_STATUS." ASC";
            $db -> fetch($stmt, array("ID" => $myId));
            break;
    }