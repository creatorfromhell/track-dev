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
include("include/handling/login.php");
$captcha = new Captcha();
$_SESSION['userspluscaptcha'] = $captcha->code;
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Login.tpl").'}';
$rules['form']['templates']['login'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/LoginForm.tpl").'}';
$rules['form']['captcha'] = $captcha->return_image();
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);