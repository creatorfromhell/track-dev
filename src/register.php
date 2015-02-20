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
$currentUser = $_SESSION['usersplusprofile'];
if($currentUser !== null) { header('LOCATION: index.php'); }
include("include/handling/register.php");
$captcha = new Captcha();
$_SESSION['userspluscaptcha'] = $captcha->code;
$rules['site']['page']['content'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "basic/AnnounceContent.tpl").'}';
if($configuration->config["main"]["registration"]) {
    $rules['site']['page']['content'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "Register.tpl").'}';
    $rules['form']['templates']['register'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "forms/RegistrationForm.tpl").'}';
    $rules['form']['captcha'] = $captcha->returnImage();
}
new SimpleTemplate($theme_manager->GetTemplate((string)$theme->name, "basic/Page.tpl"), $rules, true);