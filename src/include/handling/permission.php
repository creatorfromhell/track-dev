<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/23/14
 * Time: 12:11 PM
 * Version: Beta 1
 * Last Modified: 8/23/14 at 12:11 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['add-permission'])) {
    if(isset($_POST['node']) && trim($_POST['node']) != '') {
        if(isset($_POST['description']) && trim($_POST['description']) != '') {
            if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                nodeAdd(cleanInput($_POST['node']), cleanInput($_POST['description']));
                destroySession("userspluscaptcha");
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidcaptcha")).'");';
                echo '</script>';
            }
        } else {
            die("Invalid description entered.");
        }
    } else {
        die("Invalid node entered.");
    }
}

if(isset($_POST['edit-permission'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != '' && hasValues("nodes", " WHERE id = '".cleanInput($_POST['id'])."'")) {
        if(isset($_POST['node']) && trim($_POST['node']) != '') {
            if(isset($_POST['description']) && trim($_POST['description']) != '') {
                if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && checkCaptcha(cleanInput($_POST['captcha']))) {
                    nodeEdit(cleanInput($_POST['id']), cleanInput($_POST['node']), cleanInput($_POST['description']));
                    destroySession("userspluscaptcha");
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts($langmanager->getValue($language, "site->forms->invalidcaptcha")).'");';
                    echo '</script>';
                }
            } else {
                die("Invalid description entered.");
            }
        } else {
            die("Invalid node entered.");
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->invalidid)).'");';
        echo '</script>';
    }
}