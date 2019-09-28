<?php
    header('Access-Control-Allow-Origin: *');
    require_once("WitsFreelanceDatabaseManager.php");

    $db = new WitsFreelanceDatabaseManager();
    $ACTION = $_REQUEST[Constants::ACTION];

    switch ($ACTION){
        case Constants::POST:
            $stmt = "INSERT INTO ".Constants::RATE_TABLE."("
                .Constants::RATE_ID.","
                .Constants::JOB_ID.","
                .Constants::RATER.","
                .Constants::RATING.","
                .Constants::RATE_DATE_TIME
                .") VALUES (0, :JID, :R, :RT, :RDT)";

            $args = array(
                "JID" => $_REQUEST[Constants::JOB_ID],
                "R" => $_REQUEST[Constants::RATER],
                "RT" => $_REQUEST[Constants::RATING],
                "RDT" => date(Constants::DATE_TIME_FORMAT),
            );

            $db -> execute($stmt, $args, true);

            break;

        case Constants::VIEW_RATE:

            //$stmt =

            break;
    }