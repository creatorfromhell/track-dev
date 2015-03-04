<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/18/14
 * Time: 8:31 PM
 * Version: Beta 1
 * Last Modified: 1/18/14 at 8:31 PM
 * Last Modified by Daniel Vidmar.
 */
$location = "index.php?t=project";
if(isset($_GET['return'])) {
    $location = $_GET['return'];
}
include("include/header.php");
if(isset($_SESSION['usersplusprofile'])) { header("Location: index.php"); }

if(isset($_POST['login'])) {
    $handler = new LoginHandler($_POST);

    try {
        $handler->handle();

        $name = $this->post_vars['username'];
        $email = (!valid_email($name)) ? false : true;
        $user = User::load($name, $email);
        $user->logged_in = date("Y-m-d H:i:s");
        $user->online = 1;
        $user->save();
        ActivityFunc::log(StringFormatter::clean_input($_POST['username']), "none", "none", "user:login", "", 0, date("Y-m-d H:i:s"));

        $user_login_hook = new UserLoginHook($user->name, $user->logged_in, $user->get_ip());
        $plugin_manager->trigger($user_login_hook);

        $_SESSION['usersplusprofile'] = $user->name;
        header("Location: index.php?".$previous);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

$captcha = new Captcha();
$_SESSION['userspluscaptcha'] = $captcha->code;
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Login.tpl").'}';
$rules['form']['templates']['login'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/LoginForm.tpl").'}';
$rules['form']['captcha'] = $captcha->return_image();
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);