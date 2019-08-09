<?php
    require_once ("WitsFreelanceDatabaseManager.php");

    $db = new WitsFreelanceDatabaseManager();

    $ACTION = $_REQUEST[Constants::ACTION];

    switch ($ACTION){
        case Constants::POST:

            $stmt = "SELECT * FROM ".Constants::BID_TABLE." WHERE ".Constants::JOB_ID." = :JID AND ".Constants::BIDDER_ID
            ." = :BID";
            $args = array(
                "JID" => $_REQUEST[Constants::JOB_ID],
                "BID" => $_REQUEST[Constants::BIDDER_ID],
                "BDT" => date('d/m/Y_H:i'),
                "BSA" => $_REQUEST[Constants::BID_SUGGESTED_AMOUNT],
                "BM" => $_REQUEST[Constants::BID_MESSAGE]
            );

            if ($db -> exists($stmt, $args)) echo Constants::ALREADY_BID;
            else{
                $stmt = "INSERT INTO ".Constants::BID_TABLE." VALUES(0, :JID, :BID, :BDT, :BSA, :BM)";
                $db -> insert($stmt, $args, true);
            }
            break;
    }