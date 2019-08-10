<?php
/**
 * Created by PhpStorm.
 * User: Mulisa
 * Date: 2019/08/10
 * Time: 2:09 PM
 */
    require_once ("WitsFreelanceDatabaseManager.php");
    require_once ("BusinessManager.php");

    $db = new WitsFreelanceDatabaseManager();
    $bm = new BusinessManager();
    $ACTION = $_REQUEST[Constants::ACTION];

    $id = $_REQUEST[Constants::FUND_STUD_ID];

    switch ($ACTION){
        case Constants::POST:
            $amount = $_REQUEST[Constants::FUND_AMOUNT];
            $reason = "Deposit";
            $results = $bm -> performTransaction($id, $amount, $reason);
            echo $results != -1 ? Constants::SUCCESS : Constants::FAILED;
            break;

        case Constants::VIEW_SINGLE:
            $stmt = "SELECT * FROM ".Constants::FUND_TABLE." WHERE ".Constants::FUND_STUD_ID." = :ID";
            $db -> fetch($stmt, array("ID" => $id));
            break;
    }