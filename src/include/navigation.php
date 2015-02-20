<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/23/14
 * Time: 4:13 PM
 * Version: Beta 1
 * Last Modified: 1/23/14 at 4:45 PM
 * Last Modified by Daniel Vidmar.
 */

$tabs = array(
	"overview" => array(
		"alias" => array("index"),
		"location" => "index.php",
		"translate" => "lang:",
		"sub" => array(
			"project" => array(
				"location" => "index.php?t=project&amp;p=".$project,
				"translate" => "lang:"
			),
			"calendar" => array(
				"location" => "index.php?t=calendar&amp;p=".$project,
				"translate" => "lang:"
			),
		)
	),
	"projects" => array(
		"location" => "projects.php",
		"translate" => "lang:",
	),
	"lists" => array(
		"alias" => array("list"),
		"location" => "lists.php",
		"translate" => "lang:",
	),
);

foreach($projects as &$p) {
    $projectInfo = array(
        "location" => "lists.php?p=".$p,
        "translate" => "lang:"
    );

    $tabs['projects']['sub'][$p] = $projectInfo;
}

foreach($lists as &$l) {
    $listInfo = array(
        "location" => "list.php?p=".$project."&amp;l=".$l,
        "translate" => "lang:"
    );

    $tabs['lists']['sub'][$l] = $listInfo;
}

$navigation_main_hook = new NavigationMainHook($tabs);
$plugin_manager->trigger($navigation_main_hook);
$tabs = $navigation_main_hook->arguments['tabs'];

$navigation_tabs_string = '';
$keys = array_keys($tabs);
foreach($keys as &$tab) {
    $class = ($page == $tab || array_key_exists("sub", $tabs[$tab]) && array_key_exists($page, $tabs[$tab]['sub']) || array_key_exists("alias", $tabs[$tab]) && in_array($page, $tabs[$tab]['alias'])) ? ' class="active"' : '';
    $navigation_tabs_string .= '<li'.$class.'><a href="'.$tabs[$tab]['location'].'">'.ucfirst($tab).'</a>';
    if(array_key_exists("sub", $tabs[$tab]) && !empty($tabs[$tab]['sub'])) {
        $sub_keys = array_keys($tabs[$tab]['sub']);
        $navigation_tabs_string .= "<ul>";
        foreach($sub_keys as &$sub_tab) {
            $navigation_tabs_string .= '<li><a href="'.$tabs[$tab]['sub'][$sub_tab]['location'].'">'.ucfirst($sub_tab).'</a></li>';
        }
        $navigation_tabs_string .= "</ul>";
    }
    $navigation_tabs_string .= '</li>';
}
$rules['navigation']['main']['tabs'] = $navigation_tabs_string;