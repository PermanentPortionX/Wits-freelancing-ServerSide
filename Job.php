<?php
    require_once ("WitsFreelanceDatabaseManager.php");
    require_once ("BusinessManager.php");

    $db = new WitsFreelanceDatabaseManager();
    $bm = new BusinessManager();
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
                $jobId = $db -> insert($stmt, $args, true);

                $transactionId = $bm -> performTransaction($args["JEI"], -1*$args["JARH"],"Reserved for job post");
                $bm -> performTransaction($args["JEI"], -1 * $args["JARH"] * Constants::POST_COST, "Job Post fee");

                $stmt = "UPDATE ".Constants::JOB_TABLE." SET ".Constants::TRANSACTION_ID." = :TID WHERE ".Constants::JOB_ID." = :JID";
                $args = array("TID" => $transactionId, "JID" => $jobId);
                $db -> insert($stmt, $args, false);
            }
            else $bm -> sendInsufficientFundsError();

            break;

        case Constants::VIEW_ALL:
            $stmt = "SELECT * FROM ".Constants::JOB_TABLE;
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
    }