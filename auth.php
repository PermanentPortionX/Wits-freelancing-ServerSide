<?php
header('Access-Control-Allow-Origin: *');
require_once ("ServerInfo.php");
require_once ("Constants.php");
require_once("BusinessManager.php");

//1627982.ms.wits.ac.za/~student/auth.php?USERNAME=1627982&PASSWORD=mulisa6854727
function authenticate($user, $password) {
    $ldap = ldap_connect(ServerInfo::LDAP_HOST);
    ldap_set_option($ldap,LDAP_OPT_PROTOCOL_VERSION,3);
    ldap_set_option($ldap,LDAP_OPT_REFERRALS,0);

    //auth user
    if($bind = @ldap_bind($ldap, $user, $password)) {
        $filter = "(sAMAccountName=".$user.")";
        $result = ldap_search($ldap, ServerInfo::LDAP_DN, $filter, ServerInfo::LDAP_ATTR);
        $entry = ldap_get_entries($ldap, $result)[0];

        $info = array(
            Constants::NAME => $entry[ServerInfo::LDAP_ATTR[2]][0],
            Constants::SURNAME => $entry[ServerInfo::LDAP_ATTR[1]][0]
        );

        //mail("1627982@students.wits.ac.za", "subject", "message", "WitsFreeLance");
        $bm = new BusinessManager();
        $bm -> performTransaction($user, 0, "initial amount");

        echo json_encode($info);
    }
    else echo Constants::DEFAULT_JSON;
}

$user = $_REQUEST[Constants::STUDENT_USER];
$pass = $_REQUEST[Constants::STUDENT_PASS];

authenticate($user, $pass);