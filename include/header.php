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

$h1 = $formatter->replaceShortcuts(((string)$languageinstance->site->header));

if($page == "index") { $h1 = $formatter->replaceShortcuts(((string)$languageinstance->site->pages->overview->header)); }
else if($page == "projects") { $h1 = $formatter->replaceShortcuts(((string)$languageinstance->site->pages->projects->header)); }
else if($page == "lists") { $h1 = $formatter->replaceShortcuts(((string)$languageinstance->site->pages->lists->header)); }
else if($page == "admin") { $h1 = $formatter->replaceShortcuts(((string)$languageinstance->site->pages->admin->header)); }
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->title)); ?></title>
    <!--[if le IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
    <![endif]-->
    <?php
        foreach($manager->getIncludes((string)$theme->name) as $include) {
            echo $include;
        }
    ?>
</head>
<body>
    <header>
        <div class="login">
            <p>
                <?php if($currentUser !== null) {
                    echo "<p>Welcome, </p>".userNav()."<p>.</p>";
                } else { ?>
                    <a href="login.php?return=<?php echo $return; ?>">Login</a> or <a href="register.php">Register</a>
                <?php } ?>
            </p>
        </div>
        <?php include("navigation.php"); ?>
        <h1><?php echo $h1; ?></h1>
    </header>
    <div id="msg" onclick="closeMessage(); return false;" class="<?php echo $msgType; ?>" style="<?php if(trim($msg) === '') { echo 'display: none;'; } ?>"><?php echo $msg; ?></div>
