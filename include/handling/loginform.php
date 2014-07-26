<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:48 PM
 * Version: Beta 1
 * Last Modified: 3/18/14 at 11:39 AM
 * Last Modified by Daniel Vidmar.
 */
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
                ActivityFunc::log($username, "none", "none", "user:login", "", 0, date("Y-m-d H:i:s"));
                echo '<script>';
                echo 'window.location.assign("'.$location.'");';
                echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->login->invalidlogin)).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->login->nopassword)).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->login->nousername)).'");';
        echo '</script>';
    }
}

?>