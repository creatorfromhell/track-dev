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
if(!empty($_POST)) {

    $type = $_POST['t'];

    if($type == "checkuser") {
        if(!UserFunc::exists($_POST['username'])) {
            echo "AVAILABLE";
        } else {
            echo "TAKEN";
        }
    }
}


?>