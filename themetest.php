<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/16/14
 * Time: 1:16 PM
 * Version: Beta 1
 * Last Modified: 1/16/14 at 1:16 PM
 * Last Modified by Daniel Vidmar.
 */
require_once("include/thememanager.php");
require_once("include/config.php");

$manager = new ThemeManager();
$configuration = new Configuration();

echo(count($manager->themes)." themes loaded.");

echo("</br>Themes:</br>");
foreach($manager->themes as $theme) {
    echo "Name: ".(string)$theme->name."</br>";
    echo "Author: ".(string)$theme->author."</br>";
    echo "Version: ".(string)$theme->version."</br>";
    echo "Has JS: ".(($manager->containsJS((string)$theme->name)) ? "Yes" : "No")."</br>";
    echo "Has CSS: ".(($manager->containsCSS((string)$theme->name)) ? "Yes" : "No")."</br></br></br>";
}

foreach($manager->getIncludes("Default") as $include) {
    $installation_path = rtrim($configuration->config["urls"]["base_url"], "/").rtrim($configuration->config["urls"]["installation_path"], "/")."/";
    echo $installation_path."resources/themes/default/".$include."</br>";
}
?>