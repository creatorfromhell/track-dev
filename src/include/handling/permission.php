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
            if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {
                node_add(clean_input($_POST['node']), clean_input($_POST['description']));
                destroy_session("userspluscaptcha");
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
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
    if(isset($_POST['id']) && trim($_POST['id']) != '' && has_values("nodes", " WHERE id = '".clean_input($_POST['id'])."'")) {
        if(isset($_POST['node']) && trim($_POST['node']) != '') {
            if(isset($_POST['description']) && trim($_POST['description']) != '') {
                if(isset($_POST['captcha']) && trim($_POST['captcha']) != '' && check_captcha(clean_input($_POST['captcha']))) {
                    node_edit(clean_input($_POST['id']), clean_input($_POST['node']), clean_input($_POST['description']));
                    destroy_session("userspluscaptcha");
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidcaptcha")).'");';
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
        echo 'showMessage("error", "'.$formatter->replace_shortcuts(((string)$language_instance->site->forms->invalidid)).'");';
        echo '</script>';
    }
}