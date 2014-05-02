<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:54 PM
 * Version: Beta 1
 * Last Modified: 3/2/14 at 12:54 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_SESSION['username'])) {
    header("Location: index.php");
}

if(isset($_POST['register'])) {
    if(isset($_POST['username']) && trim($_POST['username']) != "") {
        $username = $_POST['username'];
        if(isset($_POST['password']) && trim($_POST['password']) != "") {
            if(isset($_POST['c_password']) && trim($_POST['c_password']) != "") {
                if(isset($_POST['email']) && trim($_POST['email']) != "") {
                    $email = $_POST['email'];
                    $password = UserFunc::hashPass($_POST['password']);
                    $confirm_password = UserFunc::hashPass($_POST['c_password']);

                    if(!UserFunc::exists($username)) {
                        if($password === $confirm_password) {
                            $userGroup = GroupFunc::getPreset();
                            $registered = date("Y-m-d H:i:s");
                            $lastLogin = date("Y-m-d H:i:s");
                            $ip = Utils::getIP();
                            $activationKey = UserFunc::generateActivationKey();

                            UserFunc::add($username, $password, $userGroup, $registered, $lastLogin, $ip, $email, $activationKey);
                            echo '<script type="text/javascript">';
                            echo 'showMessage("success", "Thanks for registering! You may now login.");';
                            echo '</script>';

                            echo '<script>';
                            echo 'window.location.assign("login.php");';
                            echo '</script>';
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "Passwords do not match!");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "Username already in use!");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "No email address entered!");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "You must confirm your password!");';
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