<?php
    header('Access-Control-Allow-Origin: *');
    require_once ("WitsFreelanceDatabaseManager.php");

    $db = new WitsFreelanceDatabaseManager();

    $ACTION = $_REQUEST[Constants::ACTION];

    switch ($ACTION){
        case Constants::POST:

            $stmt = "SELECT * FROM ".Constants::BID_TABLE." WHERE ".Constants::JOB_ID." = :JID AND ".Constants::BIDDER_ID." = :BID";
            $args = array(
                "JID" => $_REQUEST[Constants::JOB_ID],
                "BID" => $_REQUEST[Constants::BIDDER_ID],
                "BDT" => date(Constants::DATE_TIME_FORMAT),
                "BSA" => $_REQUEST[Constants::BID_SUGGESTED_AMOUNT],
                "BM" => $_REQUEST[Constants::BID_MESSAGE]
            );

            if ($db -> exists($stmt, array($args["JID"], $args["BID"]))) echo Constants::ALREADY_BID;
            else{
                $stmt = "INSERT INTO ".Constants::BID_TABLE." VALUES(0, :JID, :BID, :BDT, :BSA, :BM)";
                $db -> insert($stmt, $args, true);
            }

            break;

        case Constants::VIEW_ALL:
            $stmt = "SELECT * FROM ".Constants::BID_TABLE." WHERE ".Constants::JOB_ID." = :ID";
            $db -> fetch($stmt, array("ID" => $_REQUEST[Constants::JOB_ID]));
            break;
    }
