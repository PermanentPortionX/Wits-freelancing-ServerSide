<?php
header('Access-Control-Allow-Origin: *');
require_once("Constants.php");
require_once("ServerInfo.php");
require_once("NotificationManager.php");

class BusinessManager{
    private $pdo;
    private $nm;

    function __construct() {
        $this -> nm = new NotificationManager();
        $dsn = "mysql:host=".ServerInfo::SERVER_PROXY.";dbname=".ServerInfo::DATABASE.";charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this -> pdo = new PDO($dsn, ServerInfo::USER_NAME, ServerInfo::USER_PASS, $options);
        }
        catch (PDOException $e) {
            echo $e -> getMessage();
        }
    }

    function __destruct(){
        $this -> pdo = null;
    }

    function hasEnoughFunds($id, $amount){
        try{
            $amount += $amount * Constants::TRANSACTION_FEE;
            $stmt = "SELECT * FROM ".Constants::FUND_TABLE." WHERE ".Constants::FUND_STUD_ID." = :ID AND "
                .Constants::FUND_AMOUNT." >= :AM";
            $execStmt = $this -> pdo -> prepare($stmt);
            if ($execStmt -> execute(array("ID" => $id, "AM" => $amount))) return $execStmt -> rowCount() > 0;
            else return false;
        }
        catch (PDOException $e){
            echo $e -> getMessage();
            return false;
        }
    }

    function sendInsufficientFundsError(){
        echo Constants::INSUFFICIENT_FUNDS;
    }

    function performTransaction($id, $amount, $reason){
        try{
            $stmt = "SELECT * FROM ".Constants::FUND_TABLE." WHERE ".Constants::FUND_STUD_ID." = :ID";
            $execStmt = $this -> pdo -> prepare($stmt);
            if ($execStmt -> execute(array("ID" => $id))){
                if ($execStmt -> rowCount() == 0){
                    //load funds
                    $stmt = "INSERT INTO ".Constants::FUND_TABLE." VALUES(:ID, :A)";
                    $execStmt = $this -> pdo -> prepare($stmt);
                    if($execStmt -> execute(array("ID" => $id, "A" => $amount))) {
                        $this->logTransaction($id, $amount, $reason);
                    }
                    //TODO: SEND NOTIFICATION
                }
                else if ($amount != 0){
                    //update
                    $stmt = "UPDATE ".Constants::FUND_TABLE." SET ".Constants::FUND_AMOUNT." = ".Constants::FUND_AMOUNT.
                        " + :A WHERE ".Constants::FUND_STUD_ID." = :ID";
                    $execStmt = $this -> pdo -> prepare($stmt);
                    if($execStmt -> execute(array("A" => $amount, "ID" => $id))){
                        //TODO: SEND NOTIFICATION
                        $row = $execStmt -> fetch(PDO::FETCH_ASSOC);
                        $newAmount = $row[Constants::FUND_AMOUNT];
                        $message = "";
                        $this -> nm -> sendTransactionNotification($id, $amount, $newAmount, $message);
                        return $this -> logTransaction($id, $amount, $reason);
                    }

                }
            }
        }
        catch (PDOException $e){
            echo $e -> getMessage();
        }
        return -1;
    }

    function logTransaction($id, $amount, $reason){
        try{
            $stmt = "INSERT INTO ".Constants::TRANSACTION_TABLE." VALUES(0, :TDT, :TR, :TA, :FSI)";
            $execStmt = $this -> pdo -> prepare($stmt);
            $args = array(
                "TDT" => date(Constants::DATE_TIME_FORMAT),
                "TR" => $reason,
                "TA" => $amount,
                "FSI" => $id
            );
            $execStmt -> execute($args);
            return $this -> pdo -> lastInsertId(); //$execStmt -> fetch(PDO::FETCH_ASSOC)[Constants::TRANSACTION_ID];
        }
        catch (PDOException $e){
            echo $e -> getMessage();
        }
        return -1;
    }
}
