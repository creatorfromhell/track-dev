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
$currentUser = User::load($_SESSION['usersplusprofile']);
if($currentUser === null) { header('LOCATION: index.php'); }
ActivityFunc::log($currentUser->name, "none", "none", "user:logout", "", 0, date("Y-m-d H:i:s"));
$date = date("Y-m-d H:i:s");
$currentUser->loggedIn = $date;
$currentUser->online = 0;
$currentUser->save();

$user_logout_hook = new UserLogoutHook($currentUser->name, $date, $currentUser->getIP());
$plugin_manager->trigger($user_logout_hook);

destroySession("usersplusprofile");
$rules['site']['page']['content'] = '{include->'.$manager->GetTemplate((string)$theme->name, "Logout.tpl").'}';
$rules['pages']['logout']['announce'] = '{include->'.$manager->GetTemplate((string)$theme->name, "basic/AnnounceContent.tpl").'}';
$rules['site']['content']['announce'] = 'You have been logged out successfully.';
new SimpleTemplate($manager->GetTemplate((string)$theme->name, "basic/Page.tpl"), $rules, true);
?>