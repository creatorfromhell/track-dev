<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/23/14
 * Time: 12:12 PM
 * Version: Beta 1
 * Last Modified: 8/23/14 at 12:12 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['add-user'])) {
    if(isset($_POST['username']) && trim($_POST['username']) != '') {
        if(isset($_POST['email']) && trim($_POST['email']) != '' && valid_email($_POST['email'])) {
            if(isset($_POST['password']) && trim($_POST['password']) != '') {
                if(isset($_POST['c_password']) && trim($_POST['c_password']) != '') {
                    if(!User::exists($_POST['username'], false) && !User::exists($_POST['email'], true)) {
                        if($_POST['password'] == $_POST['c_password']) {
                            if(isset($_POST['group']) && trim($_POST['group']) != '') {
                                if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {
                                    $date = date("Y-m-d H:i:s");
                                    $user = new User();
                                    $user->ip = User::get_ip();
                                    $user->name = clean_input($_POST['username']);
                                    $user->email = clean_input($_POST['email']);
                                    $user->registered = $date;
                                    $user->logged_in = $date;
                                    $user->activated = 1;
                                    $user->password = generate_hash(clean_input($_POST['password']));
                                    $user->group = Group::load(clean_input($_POST['group']));
                                    $user->permissions = explode(",", clean_input($_POST['permissions-value']));
                                    User::add_user($user);
                                    $params = "name:".clean_input($_POST['username']).",email:".clean_input($_POST['email']).",group:".clean_input($_POST['group']);
                                    ActivityFunc::log($current_user->name, "none", "none", "user:add", $params, 0, date("Y-m-d H:i:s"));
                                    destroy_session("userspluscaptcha");
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
                                    echo '</script>';
                                }
                            } else {
                                die("Invalid group id.");
                            }
                        } else {
                            die("Passwords do not match.");
                        }
                    } else {
                        die("Username or email address already in use.");
                    }
                } else {
                    die("You must confirm your password.");
                }
            } else {
                die("You must enter a password.");
            }
        } else {
            die("You must enter a valid email address.");
        }
    } else {
        die("You must enter a username.");
    }
}

if(isset($_POST['edit-user'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != '' && has_values("users", " WHERE id = '".clean_input($_POST['id'])."'")) {
        $user = User::load($_POST['id'], false, true);
        if(isset($_POST['username']) && trim($_POST['username']) != '') {
            if(isset($_POST['email']) && trim($_POST['email']) != '' && valid_email($_POST['email'])) {
                if(isset($_POST['password']) && trim($_POST['password']) != '') {
                    if(isset($_POST['c_password']) && trim($_POST['c_password']) != '') {
                        if(!User::exists(clean_input($_POST['username']), false) || User::exists(clean_input($_POST['username']), false) && $user->name == clean_input($_POST['username'])) {
                            if(!User::exists(clean_input($_POST['email']), true) || User::exists(clean_input($_POST['email']), true) && $user->email == clean_input($_POST['email'])) {
                                if($_POST['password'] == $_POST['c_password']) {
                                    if(isset($_POST['group']) && trim($_POST['group']) != '') {
                                        if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {
                                            $oldName = $user->name;
                                            $oldEmail = $user->email;
                                            $oldGroup = $user->group->id;
                                            $date = date("Y-m-d H:i:s");
                                            $user->name = clean_input($_POST['username']);
                                            $user->email = clean_input($_POST['email']);
                                            $user->password = generate_hash(clean_input($_POST['password']));
                                            $user->group = Group::load(clean_input($_POST['group']));
                                            $user->permissions = explode(",", clean_input($_POST['permissions-value']));
                                            $user->save();
                                            $params = "oldname:".$oldName.",name:".clean_input($_POST['username']).",oldemail:".$oldEmail.",email:".clean_input($_POST['email']).",oldgroup:".$oldGroup.",group:".clean_input($_POST['group']);
                                            ActivityFunc::log($current_user->name, "none", "none", "user:edit", $params, 0, date("Y-m-d H:i:s"));
                                            destroy_session("userspluscaptcha");
                                        } else {
                                            echo '<script type="text/javascript">';
                                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
                                            echo '</script>';
                                        }
                                    } else {
                                        die("Invalid group id.");
                                    }
                                } else {
                                    die("Passwords do not match.");
                                }
                            } else {
                                die("Username or email address already in use.");
                            }
                        } else {
                            die("Username or email address already in use.");
                        }
                    } else {
                        die("You must confirm your password.");
                    }
                } else {
                    die("You must enter a password.");
                }
            } else {
                die("You must enter a valid email address.");
            }
        } else {
            die("You must enter a username.");
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}