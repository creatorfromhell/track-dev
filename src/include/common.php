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

//Required classes & includes
require_once("utils.php");
require_once("Configuration.php");

spl_autoload_register("autoload");
spl_autoload_register("autoload_api");

function autoload($class) {
    $configuration = new Configuration();
    $configurationValues = $configuration->config;
    $root = realpath($_SERVER["DOCUMENT_ROOT"])."/".trim($configurationValues["urls"]["installation_path"], "/");
    if(file_exists($root."/include/function/".$class.".php")) {
        require_once($root."/include/function/".$class.".php");
        return true;
    } else if(file_exists($root."/include/class/".$class.".php")) {
        require_once($root."/include/class/".$class.".php");
        return true;
    } else if(file_exists($root."/include/".$class.".php")) {
        require_once($root."/include/".$class.".php");
        return true;
    }
    return false;
}

function autoload_api($class) {
    $configuration = new Configuration();
    $configurationValues = $configuration->config;
    $root = realpath($_SERVER["DOCUMENT_ROOT"])."/".trim($configurationValues["urls"]["installation_path"], "/");
    if(file_exists($root."/api/".$class.".php")) {
        require_once($root."/api/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/".$class.".php")) {
        require_once($root."/api/hooks/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/user/".$class.".php")) {
        require_once($root."/api/hooks/user/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/navigation/".$class.".php")) {
        require_once($root."/api/hooks/navigation/".$class.".php");
        return true;
    } else if(file_exists($root."/api/hooks/addon/".$class.".php")) {
        require_once($root."/api/hooks/addon/".$class.".php");
        return true;
    }
    return false;
}

//Instances of Classes
$configuration = new Configuration();
$plugin_manager = new PluginManager($root = realpath($_SERVER["DOCUMENT_ROOT"])."/".trim($configuration->config["urls"]["installation_path"], "/"));
$manager = new ThemeManager($plugin_manager);
$langmanager = new LanguageManager($plugin_manager);

//Any includes that require other classes to be initiated go here
require_once('DB.php');

//Global variables
$prefix = $configuration->config["database"]["db_prefix"];
$trackrVersion = $configuration->config["trackr"]["version"];
$configurationValues = $configuration->config;
unset($configurationValues["database"]);
unset($configurationValues["trackr"]);
global $prefix, $configurationValues;

//Main Variables
$theme = $manager->themes[$configurationValues["main"]["theme"]];
$installation_path = rtrim($configurationValues["urls"]["base_url"], "/").rtrim($configurationValues["urls"]["installation_path"], "/")."/";
$path = $_SERVER["PHP_SELF"];
$pageFull = basename($path);
$page = basename($path, ".php");
$pn = 1;
$currentUser = null;
$language = $configurationValues["main"]["language"];
$project = ProjectFunc::getPreset();
$projects = values("projects", "project");
$list = ProjectFunc::getMain(ProjectFunc::getID($project));

if(isset($_SESSION['usersplusprofile'])) {
    if(User::exists($_SESSION['usersplusprofile'])) {
        $currentUser = User::load($_SESSION['usersplusprofile']);
    }
}

if(isset($_GET['lang']) && $langmanager->exists($_GET['lang'])) {
    $language = $_GET['lang'];
    $_SESSION['lang'] = $language;
    setcookie('lang', $language, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['lang']) && $langmanager->exists($_SESSION['lang'])) {
    $language = $_SESSION['lang'];
} else if(isset($_COOKIE['lang']) && $langmanager->exists($_COOKIE['lang'])) {
    $language = $_COOKIE['lang'];
}

if(isset($_GET['p']) && hasValues("projects", " WHERE project = '".cleanInput($_GET['p'])."'")) {
    $project = $_GET['p'];
    $_SESSION['p'] = $project;
    setcookie('p', $project, time() + (3600 * 24 * 30));
    $list = ProjectFunc::getMain($project);
} else if(isset($_SESSION['p']) && hasValues("projects", " WHERE project = '".cleanInput($_SESSION['p'])."'")) {
    $project = $_SESSION['p'];
    $list = ProjectFunc::getMain($project);
} else if(isset($_COOKIE['p']) && hasValues("projects", " WHERE project = '".cleanInput($_COOKIE['p'])."'")) {
    $project = $_COOKIE['p'];
    $list = ProjectFunc::getMain($project);
}

if(isset($_GET['l']) && hasValues("lists", " WHERE project = '".cleanInput($project)."' AND list = '".cleanInput($_GET['l'])."'")) {
    $list = $_GET['l'];
    $_SESSION['l'] = $list;
    setcookie('l', $list, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['l']) && hasValues("lists", " WHERE project = '".cleanInput($project)."' AND list = '".cleanInput($_SESSION['l'])."'")) {
    $list = $_SESSION['l'];
} else if(isset($_COOKIE['l']) && hasValues("lists", " WHERE project = '".cleanInput($project)."' AND list = '".cleanInput($_COOKIE['l'])."'")) {
    $list = $_COOKIE['l'];
}

if(isset($_GET['pn'])) {
    if($_GET['pn'] > 0) {
        $pn = $_GET['pn'];
    }
}

$languageinstance = $langmanager->languages[$language];
$return = $pageFull.'?p='.$project.'&l='.$list;
$lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");
$formatter = new StringFormatter(getName(), $project, $list, $configuration->config, $languageinstance);
$rawMsg = "";
$msg = "";
$msgType = "general";

global $language, $langmanager;

if(trim($rawMsg) !== "") {
    if(strContains($rawMsg, ":")) {
        $array = explode(":", $rawMsg);
        $msg = $array[1];
        $type = $array[0];

        switch($type) {
            case "ERROR":
                $msgType = "error";
                break;
            case "GENERAL":
                $msgType = "general";
                break;
            case "SUCCESS":
                $msgType = "success";
                break;
            default:
                $msgType = "general";
                break;
        }
    }
}
?>