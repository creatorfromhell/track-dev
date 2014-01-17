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

$manager = new ThemeManager();

echo(count($manager->themes)." themes loaded.");

echo("</br>Themes:</br>");
foreach($manager->themes as $theme) {
    echo "Name: ".(string)$theme->name."</br>";
    echo "Author: ".(string)$theme->author."</br>";
    echo "Version: ".(string)$theme->version."</br></br></br>";
}
?>