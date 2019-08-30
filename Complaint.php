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
$ACTION = $_REQUEST[Constants::ACTION];

switch ($ACTION){
    case Constants::MAKE_COMPLAINT:
        $stmt = "INSERT INTO ".Constants::COMPLAINT_TABLE." VALUES(0, :JID, :CT, :CDT, :CM)";
        $args = array(
            "JID" => $_REQUEST[Constants::JOB_ID],
            "CT" => $_REQUEST[Constants::COMPLAINT_TYPE],
            "CDT" => $_REQUEST[Constants::COMPLAINT_DATE_TIME],
            "CM" => $_REQUEST[Constants::COMPLAINT_MESSAGE]
        );

        $db -> execute($stmt, $args, true);
        break;

}
