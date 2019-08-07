<?php

require_once("Constants.php");
require_once("ServerInfo.php");

class DatabaseManager {
    private $pdo;

    function __construct() {
        $this -> pdo = new PDO('mysql:dbname='.ServerInfo::DATABASE.';host='.ServerInfo::SERVER_PROXY.';charset=utf8',
            ServerInfo::USER_NAME, ServerInfo::USER_PASS);
        $this -> pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function executeStatement($stmt, $args){
        try{
            $execStmt = $this -> pdo -> prepare($stmt);
            if($execStmt -> execute($args)) echo Constants::SUCCESS;
            else echo Constants::FAILED;
        }
        catch(PDOException $e){
            echo Constants::FAILED;
        }
    }

    function exists($stmt, $args){
        try{
            $execStmt = $this -> pdo -> prepare($stmt);

            if($execStmt -> execute($args)) return $execStmt -> rowCount() > 0;
            else return false;
        }
        catch(PDOException $e){
            return false;
        }

    }
}
