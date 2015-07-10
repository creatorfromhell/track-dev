<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/2/14
 * Time: 12:51 PM
 * Version: Beta 1
 * Last Modified: 3/2/14 at 12:51 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
if(isset($_SESSION['usersplusprofile'])) { header('LOCATION: index.php'); }

if(isset($_POST['register'])) {
    $handler = new RegisterHandler($_POST);
    try {
        $handler->handle();

        $date = date("Y-m-d H:i:s");
        $user = new User();
        $user->ip = User::get_ip();
        $user->name = $handler->post_vars['username'];
        $user->email = $handler->post_vars['email'];
        $user->registered = $date;
        $user->logged_in = $date;
        $user->password = generate_hash($handler->post_vars['password']);
        $user->group = Group::load(Group::preset());
        $user->activation_key = generate_session_id(40);

        $params = "name:".$user->name.",email:".$user->email;
        ActivityFunc::log(User::get_ip(), "none", "none", "user:register", $params, 0, date("Y-m-d H:i:s"));

        $user_register_hook = new UserRegistrationHook($user->name, $date, $user->get_ip());
        $plugin_manager->trigger($user_register_hook);

        global $configuration_values;
        if($configuration_values["main"]["email_activation"]) {
            $user->send_activation();
        }

        User::add_user($user);

        header("Location: login.php?".$previous);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

$captcha = new Captcha();
$_SESSION['userspluscaptcha'] = $captcha->code;
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}';
$rules['site']['content']['announce'] = "Registration has been disabled on this site.";
if($configuration->config["main"]["registration"]) {
    $rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Register.tpl").'}';
    $rules['form']['templates']['register'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/RegistrationForm.tpl").'}';
    $rules['form']['captcha'] = $captcha->return_image();
}
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);