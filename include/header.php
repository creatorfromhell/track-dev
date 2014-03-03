<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/23/14
 * Time: 3:52 PM
 * Version: Beta 1
 * Last Modified: 1/23/14 at 4:45 PM
 * Last Modified by Daniel Vidmar.
 */
include_once("common.php");
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title>Project Name - Trackr</title>
    <!--[if le IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
    <![endif]-->
    <?php
        foreach($manager->getIncludes((string)$theme->name) as $include) {
            $link = $installation_path."resources/themes/".((string)$theme->directory)."/".$include;
            if(strstr($link, "css") !== false) { ?>
                <link href="<?php echo $link; ?>" rel="stylesheet" type="text/css" />
            <?php } else { ?>
                <script src="<?php echo $link; ?>"></script>
            <?php
            }
        }
    ?>
</head>
<body>
    <header>
        <?php include("navigation.php"); ?>
        <h1>Tracker for Project</h1>
    </header>
