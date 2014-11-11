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
require_once("config.php");
require_once("utils.php");
require_once("thememanager.php");
require_once("stringformatter.php");
require_once("languagemanager.php");
require_once("class/group.php");
require_once("class/pagination.php");
require_once("class/captcha.php");
require_once("class/user.php");
require_once("function/projectfunc.php");
require_once("function/listfunc.php");
require_once("function/taskfunc.php");
require_once("function/labelfunc.php");
require_once("function/versionfunc.php");
require_once("function/activityfunc.php");

//Instances of Classes
$configuration = new Configuration();
$manager = new ThemeManager();
$langmanager = new LanguageManager();

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
$currentUser = null;
$language = $configurationValues["main"]["language"];
$project = ProjectFunc::getPreset();
$projects = ProjectFunc::projects();
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

if(isset($_GET['p']) && ProjectFunc::exists($_GET['p'])) {
    $project = $_GET['p'];
    $_SESSION['p'] = $project;
    setcookie('p', $project, time() + (3600 * 24 * 30));
    $list = ProjectFunc::getMain($project);
} else if(isset($_SESSION['p']) && ProjectFunc::exists($_SESSION['p'])) {
    $project = $_SESSION['p'];
    $list = ProjectFunc::getMain($project);
} else if(isset($_COOKIE['p']) && ProjectFunc::exists($_COOKIE['p'])) {
    $project = $_COOKIE['p'];
    $list = ProjectFunc::getMain($project);
}

if(isset($_GET['l']) && ListFunc::exists($project, $_GET['l'])) {
    $list = $_GET['l'];
    $_SESSION['l'] = $list;
    setcookie('l', $list, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['l']) && ListFunc::exists($project, $_SESSION['l'])) {
    $list = $_SESSION['l'];
} else if(isset($_COOKIE['l']) && ListFunc::exists($project, $_COOKIE['l'])) {
    $list = $_COOKIE['l'];
}
$languageinstance = $langmanager->languages[$language];
$return = $pageFull.'?p='.$project.'&l='.$list;
$lists = ProjectFunc::lists($project);
$formatter = new StringFormatter(getName(), $project, $list, $configuration->config, $languageinstance);
$rawMsg = "";
$msg = "";
$msgType = "general";

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