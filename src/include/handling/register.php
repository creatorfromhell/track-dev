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
        if(isset($_POST['email']) && trim($_POST['email']) != '' && valid_email($_POST['email'])) {
            if(isset($_POST['password']) && trim($_POST['password']) != '') {
                if(isset($_POST['c_password']) && trim($_POST['c_password']) != '') {
                    if(!User::exists($_POST['username'], false) && !User::exists($_POST['email'], true)) {
                        if($_POST['password'] == $_POST['c_password']) {
                            if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(StringFormatter::clean_input($_POST['captcha']))) {
                                $date = date("Y-m-d H:i:s");
                                $user = new User();
                                $user->ip = User::get_ip();
                                $user->name = StringFormatter::clean_input($_POST['username']);
                                $user->email = StringFormatter::clean_input($_POST['email']);
                                $user->registered = $date;
                                $user->logged_in = $date;
                                $user->password = generate_hash(StringFormatter::clean_input($_POST['password']));
                                $user->group = Group::load(Group::preset());
                                $user->activation_key = generate_session_id(40);
                                User::add_user($user);
                                $params = "name:".StringFormatter::clean_input($_POST['username']).",email:".$_POST['email'];
                                ActivityFunc::log(User::get_ip(), "none", "none", "user:register", $params, 0, date("Y-m-d H:i:s"));

                                $user_register_hook = new UserRegistrationHook($user->name, $date, $user->getIP());
                                $plugin_manager->trigger($user_register_hook);

                                destroy_session("userspluscaptcha");
                                global $configuration_values;
                                if($configuration_values["main"]["email_activation"]) {
                                    $user->send_activation();
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("success", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->activation")).'");';
                                    echo '</script>';
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("success", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->congrats")).'");';
                                    echo '</script>';

                                    echo '<script>';
                                    echo 'window.location.assign("login.php");';
                                    echo '</script>';
                                }
                                ?>
                            <?php
                            } else {
                                echo '<script type="text/javascript">';
                                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
                                echo '</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->invalidpasswords")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->taken")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->noconfirm")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->nopassword")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->noemail")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->login->nousername")).'");';
        echo '</script>';
    }
}