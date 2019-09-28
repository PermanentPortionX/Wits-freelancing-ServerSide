<?php
/**
 * Created by PhpStorm.
 * User: Mulisa
 * Date: 2019/08/30
 * Time: 2:01 PM
 */
header('Access-Control-Allow-Origin: *');
require_once ("WitsFreelanceDatabaseManager.php");

$db = new WitsFreelanceDatabaseManager();
$nm = new NotificationManager();

$ACTION = $_REQUEST[Constants::ACTION];

switch ($ACTION){
    case Constants::POST:
        $stmt = "INSERT INTO ".Constants::COMPLAINT_TABLE." VALUES(0, :JID, :CT, :CDT, :CM)";
        $args = array(
            "JID" => $_REQUEST[Constants::JOB_ID],
            "CT" => $_REQUEST[Constants::COMPLAINT_TYPE],
            "CDT" => date(Constants::DATE_TIME_FORMAT),
            "CM" => $_REQUEST[Constants::COMPLAINT_MESSAGE]
        );

        if($db -> execute($stmt, $args, false) != -1){
            $nm -> sendNotification("1608194", $args["CM"], "COMPLAINT");
            echo Constants::SUCCESS;
        }
        else echo Constants::FAILED;

        break;

}

