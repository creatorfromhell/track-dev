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
        if(isset($_POST['email']) && trim($_POST['email']) != '' && validEmail($_POST['email'])) {
            if(isset($_POST['password']) && trim($_POST['password']) != '') {
                if(isset($_POST['c_password']) && trim($_POST['c_password']) != '') {
                    if(!User::exists($_POST['username'], false) && !User::exists($_POST['email'], true)) {
                        if($_POST['password'] == $_POST['c_password']) {
                            if(isset($_POST['group']) && trim($_POST['group']) != '') {
                                if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                                    $date = date("Y-m-d H:i:s");
                                    $user = new User();
                                    $user->ip = User::getIP();
                                    $user->name = cleanInput($_POST['username']);
                                    $user->email = cleanInput($_POST['email']);
                                    $user->registered = $date;
                                    $user->loggedIn = $date;
                                    $user->activated = 1;
                                    $user->password = generateHash(cleanInput($_POST['password']));
                                    $user->group = Group::load(cleanInput($_POST['group']));
                                    $user->permissions = explode(",", cleanInput($_POST['permissions-value']));
                                    User::addUser($user);
                                    $params = "name:".cleanInput($_POST['username']).",email:".cleanInput($_POST['email']).",group:".cleanInput($_POST['group']);
                                    ActivityFunc::log($currentUser->name, "none", "none", "user:add", $params, 0, date("Y-m-d H:i:s"));
                                    destroySession("userspluscaptcha");
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidcaptcha")).'");';
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
    if(isset($_POST['id']) && trim($_POST['id']) != '' && User::validID(cleanInput($_POST['id']))) {
        $user = User::load($_POST['id'], false, true);
        if(isset($_POST['username']) && trim($_POST['username']) != '') {
            if(isset($_POST['email']) && trim($_POST['email']) != '' && validEmail($_POST['email'])) {
                if(isset($_POST['password']) && trim($_POST['password']) != '') {
                    if(isset($_POST['c_password']) && trim($_POST['c_password']) != '') {
                        if(!User::exists(cleanInput($_POST['username']), false) || User::exists(cleanInput($_POST['username']), false) && $user->name == cleanInput($_POST['username'])) {
                            if(!User::exists(cleanInput($_POST['email']), true) || User::exists(cleanInput($_POST['email']), true) && $user->email == cleanInput($_POST['email'])) {
                                if($_POST['password'] == $_POST['c_password']) {
                                    if(isset($_POST['group']) && trim($_POST['group']) != '') {
                                        if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                                            $oldName = $user->name;
                                            $oldEmail = $user->email;
                                            $oldGroup = $user->group->id;
                                            $date = date("Y-m-d H:i:s");
                                            $user->name = cleanInput($_POST['username']);
                                            $user->email = cleanInput($_POST['email']);
                                            $user->password = generateHash(cleanInput($_POST['password']));
                                            $user->group = Group::load(cleanInput($_POST['group']));
                                            $user->permissions = explode(",", cleanInput($_POST['permissions-value']));
                                            $user->save();
                                            $params = "oldname:".$oldName.",name:".cleanInput($_POST['username']).",oldemail:".$oldEmail.",email:".cleanInput($_POST['email']).",oldgroup:".$oldGroup.",group:".cleanInput($_POST['group']);
                                            ActivityFunc::log($currentUser->name, "none", "none", "user:edit", $params, 0, date("Y-m-d H:i:s"));
                                            destroySession("userspluscaptcha");
                                        } else {
                                            echo '<script type="text/javascript">';
                                            echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidcaptcha")).'");';
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
        echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}