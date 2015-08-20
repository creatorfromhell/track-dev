<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/18/14
 * Time: 12:49 PM
 * Version: Beta 1
 * Last Modified: 8/18/14 at 12:49 PM
 * Last Modified by Daniel Vidmar.
 */
include_once("include/header.php");
if(page_locked($current_user, "", true)) { die("Invalid permissions!"); }
$page = "activate";
if(isset($_GET['page'])) {
    $page = $_GET['page'];
}
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}';
if($page == "resend") {
    include_once("include/pages/activate/resend.php");
} else {
    include_once("include/pages/activate/activate.php");
}
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);