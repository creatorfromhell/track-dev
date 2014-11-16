<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/23/14
 * Time: 12:09 PM
 * Version: Beta 1
 * Last Modified: 8/23/14 at 12:09 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['login'])) {
    if(isset($_POST['username']) && trim($_POST['username']) != '') {
        if(isset($_POST['password']) && trim($_POST['password']) != '') {
            if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                $name = cleanInput($_POST['username']);
                $email = (!validEmail($name)) ? false : true;
                if(User::exists($name, $email) && checkHash(User::getHashedPassword($name, $email), cleanInput($_POST['password']))) {
                    $user = User::load($name, $email);
					global $configurationValues;
                    if($configurationValues["main"]["email_activation"] && $user->activated == 1 || !$configurationValues["main"]["email_activation"]) {
                        $user->loggedIn = date("Y-m-d H:i:s");
                        $user->online = 1;
                        $user->save();
                        ActivityFunc::log(cleanInput($_POST['username']), "none", "none", "user:login", "", 0, date("Y-m-d H:i:s"));

                        $_SESSION['usersplusprofile'] = $user->name;
                        destroySession("userspluscaptcha");
                        ?>
                        <script>
                            window.location.assign("index.php");
                        </script>
                    <?php
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->noactivation")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->invalidlogin")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidcaptcha")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->nopassword")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->login->nousername")).'");';
        echo '</script>';
    }
}
?>