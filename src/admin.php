<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/9/14
 * Time: 10:48 AM
 * Version: Beta 1
 * Last Modified: 5/9/14 at 10:48 AM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
if(pageLockedAdmin($currentUser)) { header('LOCATION: index.php'); }
$type = "dashboard";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}

$admin_tabs = array(
	"dashboard" => array(
        "template" => "pages/admin/Dashboard.tpl",
		"include" => "include/pages/admin/dashboard.php",
		"location" => "admin.php?t=dashboard",
		"translate" => "lang:"
	),
	"activity" => array(
        "template" => "pages/admin/Activity.tpl",
		"include" => "include/pages/admin/activity.php",
		"location" => "admin.php?t=activity",
		"translate" => "lang:"
	),
	"groups" => array(
        "template" => "pages/admin/Groups.tpl",
		"include" => "include/pages/admin/groups.php",
		"location" => "admin.php?t=groups",
		"translate" => "lang:"
	),
	"options" => array(
        "template" => "pages/admin/Options.tpl",
		"include" => "include/pages/admin/options.php",
		"location" => "admin.php?t=options",
		"translate" => "lang:"
	),
	"permissions" => array(
        "template" => "pages/admin/Permissions.tpl",
		"include" => "include/pages/admin/permissions.php",
		"location" => "admin.php?t=permissions",
		"translate" => "lang:"
	),
	"addons" => array(
        "template" => "pages/admin/Addons.tpl",
		"include" => "include/pages/admin/addons.php",
		"location" => "admin.php?t=addons",
		"translate" => "lang:"
	),
	"users" => array(
        "template" => "pages/admin/Users.tpl",
		"include" => "include/pages/admin/users.php",
		"location" => "admin.php?t=users",
		"translate" => "lang:"
	)
);

$navigation_admin_hook = new NavigationAdminHook($admin_tabs);
$plugin_manager->trigger($navigation_admin_hook);

$admin_tabs_string = '';
$keys = array_keys($admin_tabs);
foreach($keys as &$tab) {
    $class = ($type == $tab) ? ' class="active"' : '';
    $admin_tabs_string .= '<li'.$class.'><a href="'.$admin_tabs[$tab]['location'].'">'.ucfirst($tab).'</a></li>';
}

$rules['site']['page']['content'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "Admin.tpl").'}';
$rules['pages']['content']['admin'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "base/AnnounceContent.tpl").'}';
$rules['site']['content']['announce'] = 'The page you are looking for could not be found.';
$rules['navigation']['admin']['template'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "basic/AdminNavigation.tpl").'}';
$rules['navigation']['admin']['tabs'] = $admin_tabs_string;

if(array_key_exists($type, $admin_tabs)) {
    include_once($admin_tabs[$type]['include']);
    $rules['pages']['content']['admin'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, $admin_tabs[$type]['template']).'}';
}
new SimpleTemplate($theme_manager->GetTemplate((string)$theme->name, "basic/AdminPage.tpl"), $rules, true);
