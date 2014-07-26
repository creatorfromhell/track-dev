<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/17/14
 * Time: 1:40 AM
 * Version: Beta 1
 * Last Modified: 5/17/14 at 1:40 AM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['add'])) {
    if(isset($_POST['name']) && trim($_POST['name']) != "") {
        if(isset($_POST['permission']) && trim($_POST['permission']) != "") {
            if(isset($_POST['preset']) && trim($_POST['preset']) != "") {
                if(isset($_POST['admin']) && trim($_POST['admin']) != "") {
                    if(!GroupFunc::exists($_POST['name'])) {
                        GroupFunc::add($_POST['name'], $_POST['permission'], $_POST['preset'], $_POST['admin']);
                        $params = "name:".$_POST['name'].",permission:".$_POST['permission'].",admin:".$_POST['admin'];
                        ActivityFunc::log($username, "none", "none", "group:add", $params, 0, date("Y-m-d H:i:s"));
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->group->taken)).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->group->noadmin)).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->group->nopreset)).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->group->nopermission)).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noname)).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit'])) {
}