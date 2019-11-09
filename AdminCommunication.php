<?php
    header('Access-Control-Allow-Origin: *');
    require_once("NotificationManager.php");
    require_once("Constants.php");

    $SUBJECT = $_REQUEST[Constants::SUBJECT];
    $MESSAGE = $_REQUEST[Constants::MESSAGE];

    $nm = new NotificationManager();

    $nm -> sendNotification("1608194", $MESSAGE, $SUBJECT);