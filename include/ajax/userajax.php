<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/3/14
 * Time: 10:20 AM
 * Version: Beta 1
 * Last Modified: 3/3/14 at 10:20 AM
 * Last Modified by Daniel Vidmar.
 */
require_once("../function/userfunc.php");
if(!empty($_GET)) {

    $type = $_GET['t'];

    if($type == "register") {
        if(!UserFunc::exists($_POST['username'])) {
            echo "AVAILABLE";
        } else {
            echo "TAKEN";
        }
    } else if($type == "login") {
        if(UserFunc::exists($_POST['username'])) {
            if(UserFunc::validatePassword($_POST['username'], $_POST['password'])) {
                echo "EH";
            } else {
                echo "WRONG";
            }
        } else {
            echo "EMPTY";
        }
    }
}


?>