<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/24/14
 * Time: 2:37 PM
 * Version: Beta 1
 * Last Modified: 1/24/14 at 2:37 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
$type = "project";
if(isset($_GET['t'])) {
    $type = $_GET['t'];
}
$return .= "&t=".$type;
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Overview.tpl").'}';
if($type == "calendar" || $type == "calendarview") {
    include('include/pages/overview/calendar.php');
} else {
    include('include/pages/overview/project.php');
}
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);