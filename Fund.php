<?php
/**
 * Created by PhpStorm.
 * User: Mulisa
 * Date: 2019/08/10
 * Time: 2:09 PM
 */
    header('Access-Control-Allow-Origin: *');
    require_once("WitsFreelanceDatabaseManager.php");
    require_once("BusinessManager.php");
    require_once("NotificationManager.php");

    $db = new WitsFreelanceDatabaseManager();
    $bm = new BusinessManager();
    $nm = new NotificationManager();

    $ACTION = $_REQUEST[Constants::ACTION];
    $id = $_REQUEST[Constants::FUND_STUD_ID];

    switch ($ACTION){
        case Constants::POST:
            $amount = $_REQUEST[Constants::FUND_AMOUNT];
            $reason = "Deposit";
            $results = $bm -> performTransaction($id, $amount, $reason);
            if($results != -1){
                    $nm -> sendNotification($id, $amount." Was successfully deposited in your account", "Money deposit success");
            }
            echo $results != -1 ? Constants::SUCCESS : Constants::FAILED;
            break;

        case Constants::VIEW_SINGLE:
            $stmt = "SELECT * FROM ".Constants::FUND_TABLE." WHERE ".Constants::FUND_STUD_ID." = :ID";
            $stmt = $db -> getPdo() -> prepare($stmt);
            if ($stmt -> execute(array("ID" => $id))){
                $row = $stmt -> fetch(PDO::FETCH_ASSOC);

                $results = array();
                $results[] = $row;

                $stmt = "SELECT * FROM ".Constants::TRANSACTION_TABLE." WHERE ".Constants::FUND_STUD_ID." = :ID ORDER BY "
                    .Constants::TRANSACTION_ID." DESC";
                $stmt = $db -> getPdo() -> prepare($stmt);

                if ($stmt -> execute(array("ID" => $id))){
                    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) $results[] = $row;
                }

                echo json_encode($results);

            }
            else echo json_encode(Constants::DEFAULT_JSON_ARRAY);

            //$db -> fetch($stmt, array("ID" => $id));
            break;
    }