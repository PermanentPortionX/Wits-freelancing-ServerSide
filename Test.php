<?php

    require_once ("DatabaseManager.php");

    $stmt = "INSERT INTO WF_FUND(:ID, :AM)";
    $args = array(":ID" => 1627982, ":AM" => 30000);

    $databaseManager = new DatabaseManager();
    $databaseManager -> executeStatement($stmt, $args);
