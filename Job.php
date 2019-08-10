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
                "JPDT" => date('d/m/Y_H:i'),
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
            /*$stmt = "SELECT :JID, :JEID, :JT, :JD, :JPDT, :JARL, :JARH, :JDDT, :JL, :JC, COUNT(:BID) AS :N
            FROM :T1 INNER JOIN :T2 ON :T1.:JID = :T2.:JID WHERE :JS = :JSC GROUP BY :JID";*/
            $stmt = "SELECT :JID, :JEID, :JT, :JD, :JPDT, :JARL, :JARH, :JDDT, :JL, :JC, COUNT(:BID) AS NUM_OF_BIDS FROM "
                .Constants::JOB_TABLE." INNER JOIN ".Constants::BID_TABLE." ON "
                .Constants::JOB_TABLE.".".Constants::JOB_ID." = "
                .Constants::BID_TABLE.".".Constants::JOB_ID." WHERE "
                .Constants::JOB_STATUS." = ".Constants::OPEN." GROUP BY "
                .Constants::JOB_ID;
            $args = array(
                "JID" => Constants::JOB_ID,
                "JEID" => Constants::JOB_EMPLOYER_ID,
                "JT" => Constants::JOB_TITLE,
                "JD" => Constants::JOB_DESCRIPTION,
                "JPDT" => Constants::JOB_POST_DATE_TIME,
                "JARL" => Constants::JOB_AMOUNT_RANGE_LOW,
                "JARH" => Constants::JOB_AMOUNT_RANGE_HIGH,
                "JS" => Constants::JOB_STATUS,
                "JSC" => Constants::OPEN,
                "JDDT" => Constants::JOB_DUE_DATE_TIME,
                "JL" => Constants::JOB_LOCATION,
                "JC" => Constants::JOB_CATEGORY,
                "BID" => Constants::BID_ID,
                "N" => "NUM_OF_BID",
                "T1" => Constants::JOB_TABLE,
                "T2" => Constants::BID_TABLE
            );
            $db -> fetch($stmt, $args);
            break;
    }