<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/26/14
 * Time: 8:22 PM
 * Version: Beta 1
 * Last Modified: 3/26/14 at 8:22 PM
 * Last Modified by Daniel Vidmar.
 */

include("include/header.php");
$current_user = User::load($_SESSION['usersplusprofile']);
if($current_user === null) { header('LOCATION: index.php?'.$previous); }
ActivityFunc::log($current_user->name, "none", "none", "user:logout", "", 0, date("Y-m-d H:i:s"));
$date = date("Y-m-d H:i:s");
$current_user->logged_in = $date;
$current_user->online = 0;
$current_user->save();

$user_logout_hook = new UserLogoutHook($current_user->name, $date, $current_user->get_ip());
$plugin_manager->trigger($user_logout_hook);

destroy_session("usersplusprofile");
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Logout.tpl").'}';
$rules['pages']['logout']['announce'] = '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}';
$rules['site']['content']['announce'] = 'You have been logged out successfully.';
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);