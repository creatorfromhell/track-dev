<?php
/**
 * Created by Daniel Vidmar.
 * Date: 6/27/14
 * Time: 8:25 AM
 * Version: Beta 1
 * Last Modified: 6/27/14 at 8:25 AM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['add-label'])) {
    if(isset($_POST['project']) && trim($_POST['project']) != "") {
        if(isset($_POST['list']) && trim($_POST['list']) != "") {
            if(isset($_POST['labelname']) && trim($_POST['labelname']) != "") {
                if(isset($_POST['textcolor']) && trim($_POST['textcolor']) != "") {
                    if(isset($_POST['backgroundcolor']) && trim($_POST['backgroundcolor']) != "") {
                        LabelFunc::add_label($_POST['project'], $_POST['list'], $_POST['labelname'], $_POST['textcolor'], $_POST['backgroundcolor']);
                        $params = "name:".$_POST['name'].",textcolor:".$_POST['textcolor'].",backgroundcolor:".$_POST['backgroundcolor'];
                        ActivityFunc::log($current_user->name, $_POST['project'], $_POST['list'], "label:add", $params, 0, date("Y-m-d H:i:s"));
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->label->nobackgroundcolor")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->label->notextcolor")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->label->nolabel")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->invalidlist")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->invalidproject")).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit-label'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != "") {
        if(isset($_POST['project']) && trim($_POST['project']) != "") {
            if(isset($_POST['list']) && trim($_POST['list']) != "") {
                if(isset($_POST['labelname']) && trim($_POST['labelname']) != "") {
                    if(isset($_POST['textcolor']) && trim($_POST['textcolor']) != "") {
                        if(isset($_POST['backgroundcolor']) && trim($_POST['backgroundcolor']) != "") {
                            LabelFunc::edit_label($_POST['id'], $_POST['project'], $_POST['list'], $_POST['labelname'], $_POST['textcolor'], $_POST['backgroundcolor']);
                            $params = "id:".$_POST['id'].",name:".$_POST['name'].",textcolor:".$_POST['textcolor'].",backgroundcolor:".$_POST['backgroundcolor'];
                            ActivityFunc::log($current_user->name, $_POST['project'], $_POST['list'], "label:edit", $params, 0, date("Y-m-d H:i:s"));
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->label->nobackgroundcolor")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->label->notextcolor")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->label->nolabel")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->invalidlist")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->invalidproject")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}