<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:48 PM
 * Version: Beta 1
 * Last Modified: 3/2/14 at 12:48 PM
 * Last Modified by Daniel Vidmar.
 */
require_once("../function/userfunc.php");
if(!empty($_POST)) {
    $username = $_POST['username'];

    UserFunc::updateLoginDate($username);

    if(!UserFunc::loggedIn($username)) {
        UserFunc::changeStatus($username);
    }
} else {

}

?>