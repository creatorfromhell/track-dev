<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/18/14
 * Time: 8:33 PM
 * Version: Beta 1
 * Last Modified: 1/23/14 at 4:45 PM
 * Last Modified by Daniel Vidmar.
 */
session_start();
define('base_directory', rtrim(realpath(__DIR__), '/').'/');

//Required classes & includes
require_once("utils.php");
require_once("Configuration.php");

spl_autoload_register("auto_load");
spl_autoload_register("auto_load_api");

function auto_load($class) {
    $configuration = new Configuration();
    $root = realpath($_SERVER["DOCUMENT_ROOT"])."/".trim($configuration->config["urls"]["installation_path"], "/");
    if(file_exists($root."/include/function/".$class.".php")) {
        require_once($root."/include/function/".$class.".php");
        return true;
    } else if(file_exists($root."/include/class/".$class.".php")) {
        require_once($root."/include/class/".$class.".php");
        return true;
    } else if(file_exists($root."/include/".$class.".php")) {
        require_once($root."/include/".$class.".php");
        return true;
    } else if(file_exists($root."/include/handling/".$class.".php")) {
        require_once($root."/include/handling/".$class.".php");
        return true;
    } else if(file_exists($root."/include/handling/add/".$class.".php")) {
        require_once($root."/include/handling/add/".$class.".php");
        return true;
    } else if(file_exists($root."/include/handling/edit/".$class.".php")) {
        require_once($root."/include/handling/edit/".$class.".php");
        return true;
    } else if(file_exists($root."/resources/plugins/".$class.".php")) {
        require_once($root."/resources/plugins/".$class.".php");
        return true;
    }
    return false;
}

function auto_load_api($class) {
    $configuration = new Configuration();
    $root = realpath($_SERVER["DOCUMENT_ROOT"])."/".trim($configuration->config["urls"]["installation_path"], "/");
    if(file_exists($root."/api/".$class.".php")) {
        require_once($root."/api/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/".$class.".php")) {
        require_once($root."/api/hooks/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/addon/".$class.".php")) {
        require_once($root."/api/hooks/addon/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/download/".$class.".php")) {
        require_once($root."/api/hooks/download/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/group/".$class.".php")) {
        require_once($root."/api/hooks/group/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/label/".$class.".php")) {
        require_once($root."/api/hooks/label/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/list/".$class.".php")) {
        require_once($root."/api/hooks/list/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/navigation/".$class.".php")) {
        require_once($root."/api/hooks/navigation/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/node/".$class.".php")) {
        require_once($root."/api/hooks/node/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/project/".$class.".php")) {
        require_once($root."/api/hooks/project/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/task/".$class.".php")) {
        require_once($root."/api/hooks/task/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/type/".$class.".php")) {
        require_once($root."/api/hooks/type/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/user/".$class.".php")) {
        require_once($root."/api/hooks/user/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/version/".$class.".php")) {
        require_once($root."/api/hooks/version/".$class.".php");
        return true;
    }
    return false;
}

//Configuration stuff
$configuration = new Configuration();
$configuration_values = $configuration->config;

//MySQl stuff
$pdo = new PDO("mysql:host=".$configuration_values["database"]["db_host"].";dbname=".$configuration_values["database"]["db_name"], $configuration_values["database"]["db_username"], $configuration_values["database"]["db_password"]);


//User Stuff
$current_user = null;
if(isset($_SESSION['usersplusprofile'])) {
    if(User::exists($_SESSION['usersplusprofile'])) {
        $current_user = User::load($_SESSION['usersplusprofile']);
    }
}

//Global variables
$prefix = $configuration->config["database"]["db_prefix"];
$trackr_version = $configuration->config["trackr"]["version"];
unset($configuration_values["database"]);
unset($configuration_values["trackr"]);
global $pdo, $prefix, $configuration_values;

//Project & List Stuff
$project = ProjectFunc::get_preset();
$projects = values("projects", "project");
$list = ProjectFunc::get_main(ProjectFunc::get_id($project));

if(isset($_GET['p']) && has_values("projects", " WHERE project = ?", array($_GET['p']))) {
    $project = $_GET['p'];
    $_SESSION['p'] = $project;
    setcookie('p', $project, time() + (3600 * 24 * 30));
    $list = ProjectFunc::get_main($project);
} else if(isset($_SESSION['p']) && has_values("projects", " WHERE project = ?", array($_SESSION['p']))) {
    $project = $_SESSION['p'];
    $list = ProjectFunc::get_main($project);
} else if(isset($_COOKIE['p']) && has_values("projects", " WHERE project = ?", array($_COOKIE['p']))) {
    $project = $_COOKIE['p'];
    $list = ProjectFunc::get_main($project);
}

$lists = values("lists", "list", " WHERE project = ?", array($project));

if(isset($_GET['l']) && has_values("lists", " WHERE project = ? AND list = ?", array($project, $_GET['l']))) {
    $list = $_GET['l'];
    $_SESSION['l'] = $list;
    setcookie('l', $list, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['l']) && has_values("lists", " WHERE project = ? AND list = ?", array($project, $_SESSION['l']))) {
    $list = $_SESSION['l'];
} else if(isset($_COOKIE['l']) && has_values("lists", " WHERE project = ? AND list = ?", array($project, $_COOKIE['l']))) {
    $list = $_COOKIE['l'];
}

//String Formatter
$formatter = new StringFormatter(get_name(), $project, $list, $configuration_values);

//Addon stuff
$plugin_manager = new PluginManager($root = realpath($_SERVER["DOCUMENT_ROOT"])."/".trim($configuration_values["urls"]["installation_path"], "/"));
$theme_manager = new ThemeManager($plugin_manager);
$language_manager = new LanguageManager($plugin_manager, $formatter);

$language = $configuration_values["main"]["language"];
$theme = $theme_manager->themes[$configuration_values["main"]["theme"]];


if(isset($_GET['lang']) && $language_manager->exists($_GET['lang'])) {
    $language = $_GET['lang'];
    $_SESSION['lang'] = $language;
    setcookie('lang', $language, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['lang']) && $language_manager->exists($_SESSION['lang'])) {
    $language = $_SESSION['lang'];
} else if(isset($_COOKIE['lang']) && $language_manager->exists($_COOKIE['lang'])) {
    $language = $_COOKIE['lang'];
}

//Page & Path variables
$installation_path = rtrim($configuration_values["urls"]["base_url"], "/").rtrim($configuration_values["urls"]["installation_path"], "/")."/";
$path = $_SERVER["PHP_SELF"];
$page_full = basename($path);
$page = basename($path, ".php");
$previous_page = (isset($_GET['prev'])) ? StringFormatter::clean_input($_GET['prev']) : "";
$previous = 'prev='.$page;
$return = $page_full.'?p='.$project.'&l='.$list;
$pn = 1;

if(isset($_GET['pn'])) {
    if($_GET['pn'] > 0) {
        $pn = $_GET['pn'];
    }
}

//Message variables
$raw_msg = "";
$msg = "";
$msg_type = "general";

if(trim($raw_msg) !== "") {
    if(str_contains($raw_msg, ":")) {
        $array = explode(":", $raw_msg);
        $msg = $array[1];
        $type = $array[0];

        switch($type) {
            case "ERROR":
                $msg_type = "error";
                break;
            case "GENERAL":
                $msg_type = "general";
                break;
            case "SUCCESS":
                $msg_type = "success";
                break;
            default:
                $msg_type = "general";
                break;
        }
    }
}