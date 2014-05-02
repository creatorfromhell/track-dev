<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:48 PM
 * Version: Beta 1
 * Last Modified: 3/18/14 at 11:39 AM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_SESSION['username'])) {
    header("Location: index.php");
}

if(isset($_POST['login'])) {
    if(isset($_POST['username']) && trim($_POST['username']) != "") {
        $username = $_POST['username'];
        if(isset($_POST['password']) && trim($_POST['password']) != "") {
            if(UserFunc::exists($username) && UserFunc::validatePassword($username, $_POST['password'])) {
                UserFunc::updateLoginDate($username);

                if(!UserFunc::loggedIn($username)) {
                    UserFunc::changeStatus($username);
                }
                $_SESSION['username'] = $username;

                echo '<script>';
                echo 'window.location.assign("projects.php");';
                echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "Invalid login credentials!");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "No password entered!");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "No username entered!");';
        echo '</script>';
    }
}

?>