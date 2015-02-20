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
            if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {
                $name = clean_input($_POST['username']);
                $email = (!valid_email($name)) ? false : true;
                if(User::exists($name, $email) && check_hash(User::get_hashed_password($name, $email), clean_input($_POST['password']))) {
                    $user = User::load($name, $email);
					global $configuration_values;
                    if($configuration_values["main"]["email_activation"] && $user->activated == 1 || !$configuration_values["main"]["email_activation"]) {
                        $user->logged_in = date("Y-m-d H:i:s");
                        $user->online = 1;
                        $user->save();
                        ActivityFunc::log(clean_input($_POST['username']), "none", "none", "user:login", "", 0, date("Y-m-d H:i:s"));

                        $user_login_hook = new UserLoginHook($user->name, $user->logged_in, $user->get_ip());
                        $plugin_manager->trigger($user_login_hook);

                        $_SESSION['usersplusprofile'] = $user->name;
                        destroy_session("userspluscaptcha");
                        ?>
                        <script>
                            window.location.assign("index.php");
                        </script>
                    <?php
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->noactivation")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->invalidlogin")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->nopassword")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->nousername")).'");';
        echo '</script>';
    }
}