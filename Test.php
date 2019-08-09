<?php

    require_once ("WitsFreelanceDatabaseManager.php");

    $stmt = "INSERT INTO WF_FUND VALUES(:ID, :AM)";
    $args = array("ID" => 1627982, "AM" => 30000);

    $db = new WitsFreelanceDatabaseManager();
    $db -> insert($stmt, $args);
