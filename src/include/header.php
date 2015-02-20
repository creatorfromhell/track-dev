<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/23/14
 * Time: 3:52 PM
 * Version: Beta 1
 * Last Modified: 1/23/14 at 4:45 PM
 * Last Modified by Daniel Vidmar.
 */
include_once('common.php');

$title = $formatter->replace_shortcuts(((string)$language_instance->site->title));
$h1 = $formatter->replace_shortcuts(((string)$language_instance->site->header));
$includes = "";
$theme_copyright = $theme_manager->replace_shortcuts((string)$theme->name, (string)$theme->copyright);
$language_select = "";
$user_bar = (logged_in()) ? "<p>Welcome, </p>".user_nav()."<p>.</p>" : "<a href=\"login.php?return=".$return."\">Login</a> or <a href=\"register.php\">Register</a>";

if($page == "index") { $h1 = $formatter->replace_shortcuts(((string)$language_instance->site->pages->overview->header)); }
else if($page == "projects") { $h1 = $formatter->replace_shortcuts(((string)$language_instance->site->pages->projects->header)); }
else if($page == "lists") { $h1 = $formatter->replace_shortcuts(((string)$language_instance->site->pages->lists->header)); }
else if($page == "admin") { $h1 = $formatter->replace_shortcuts(((string)$language_instance->site->pages->admin->header)); }

foreach($theme_manager->get_includes((string)$theme->name) as $include) {
    $includes .= $include;
}

foreach($language_manager->languages as &$lang) {
    $selected = ((string)$lang->short == $language) ? "Selected" : "";
    $language_select .= '<option value="'.(string)$lang->short.'" '.$selected.'>'.(string)$lang->name.'</option>';
}

$rules = array(
    'theme' => array(
        'includes' => $includes,
        'copyright' => $theme_copyright,
    ),
    'language' => array(
        'site' => array(
            'title' => $title,
        ),
        'select' => $language_select,
    ),
    'message' => array(
        'type' => $msg_type,
        'style' => (trim($msg) == '') ? 'display:none;' : ' ',
        'text' => $msg,
    ),
    'site' => array(
        'user_bar' => $user_bar,
        'header' => array(
            'h1' => $h1,
            'template' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/Header.tpl").'}',
        ),
        'footer' => array(
            'template' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/Footer.tpl").'}',
        ),
    ),
    'navigation' => array(
        'main' => array(
            'template' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/Navigation.tpl").'}',
        ),
    ),
    'pages'=> array(
        'switch' => ' ',
    ),
    'year' => date('Y'),
);
include_once('navigation.php');