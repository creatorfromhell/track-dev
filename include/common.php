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
require_once("thememanager.php");
require_once("config.php");
require_once("function/projectfunc.php");
require_once("function/listfunc.php");
require_once("function/userfunc.php");

//Instances of Classes
$configuration = new Configuration();
$manager = new ThemeManager();

//Main Variables
$theme = $manager->themes[$configuration->config["main"]["theme"]];
$installation_path = rtrim($configuration->config["urls"]["base_url"], "/").rtrim($configuration->config["urls"]["installation_path"], "/")."/";
$path = $_SERVER["PHP_SELF"];
$page = basename($path);
$page = basename($path, ".php");
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "guest";
$language = "en";
$project = ProjectFunc::getPreset();
$list = ProjectFunc::getMain($project);

if(isset($_GET['lang'])) {
    $language = $_GET['lang'];
    $_SESSION['lang'] = $language;
    setcookie('lang', $language, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['lang'])) {
    $language = $_SESSION['lang'];
} else if(isset($_COOKIE['lang'])) {
    $language = $_COOKIE['lang'];
}

if(isset($_GET['p']) && ProjectFunc::exists($_GET['p'])) {
    $project = $_GET['p'];
    $_SESSION['p'] = $l;
    setcookie('p', $project, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['p']) && ProjectFunc::exists($_GET['p'])) {
    $project = $_SESSION['p'];
} else if(isset($_COOKIE['p']) && ProjectFunc::exists($_GET['p'])) {
    $project = $_COOKIE['p'];
}

if(isset($_GET['l']) && ListFunc::exists($_GET['l'], $project)) {
    $list = $_GET['l'];
    $_SESSION['l'] = $l;
    setcookie('l', $list, time() + (3600 * 24 * 30));
} else if(isset($_SESSION['l']) && ListFunc::exists($_GET['l'], $list)) {
    $list = $_SESSION['l'];
} else if(isset($_COOKIE['l']) && ListFunc::exists($_GET['l'], $list)) {
    $list = $_COOKIE['l'];
}
?>