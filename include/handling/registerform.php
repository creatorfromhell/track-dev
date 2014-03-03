<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:54 PM
 * Version: Beta 1
 * Last Modified: 3/2/14 at 12:54 PM
 * Last Modified by Daniel Vidmar.
 */
require_once("../function/userfunc.php");
require_once("../function/groupfunc.php");
require_once("../utils.php");
if(!empty($_POST)) {
    //$username, $password, $usergroup, $registered, $lastlogin, $ip, $email, $activationKey
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = UserFunc::hashPass($_POST['password']);
    $usergroup = GroupFunc::getPreset();
    $registered = date("Y-m-d H:i:s");
    $lastlogin = date("Y-m-d H:i:s");
    $ip = Utils::getIP();
    $activationkey = UserFunc::generateActivationKey();

    UserFunc::add($username, $password, $usergroup, $registered, $lastlogin, $ip, $email, $activationkey);
} else {
    header("Location: ../../register.php");
}

?>