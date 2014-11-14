<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/23/14
 * Time: 12:10 PM
 * Version: Beta 1
 * Last Modified: 8/23/14 at 12:10 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['register'])) {
    if(isset($_POST['username']) && trim($_POST['username']) != '') {
        if(isset($_POST['email']) && trim($_POST['email']) != '' && validEmail($_POST['email'])) {
            if(isset($_POST['password']) && trim($_POST['password']) != '') {
                if(isset($_POST['c_password']) && trim($_POST['c_password']) != '') {
                    if(!User::exists($_POST['username'], false) && !User::exists($_POST['email'], true)) {
                        if($_POST['password'] == $_POST['c_password']) {
                            if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                                $date = date("Y-m-d H:i:s");
                                $user = new User();
                                $user->id = User::getAvailableID();
                                $user->ip = User::getIP();
                                $user->name = cleanInput($_POST['username']);
                                $user->email = cleanInput($_POST['email']);
                                $user->registered = $date;
                                $user->loggedIn = $date;
                                $user->password = generateHash(cleanInput($_POST['password']));
                                $user->group = Group::load(Group::preset());
                                $user->activationKey = generateSessionID(40);
                                User::addUser($user);
                                $params = "name:".cleanInput($_POST['username']).",email:".$_POST['email'];
                                ActivityFunc::log(User::getIP(), "none", "none", "user:register", $params, 0, date("Y-m-d H:i:s"));
                                destroySession("userspluscaptcha");
                                global $configurationValues;
                                if($configurationValues["main"]["email_activation"]) {
                                    $user->sendActivation();
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("success", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->activation")).'");';
                                    echo '</script>';
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("success", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->congrats")).'");';
                                    echo '</script>';

                                    echo '<script>';
                                    echo 'window.location.assign("login.php");';
                                    echo '</script>';
                                }
                                ?>
                            <?php
                            } else {
                                echo '<script type="text/javascript">';
                                echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidcaptcha")).'");';
                                echo '</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->invalidpasswords")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->taken")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->noconfirm")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->nopassword")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->noemail")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->nousername")).'");';
        echo '</script>';
    }
}
?>