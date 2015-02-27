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
                        $project = $_POST['project'];
                        $list = $_POST['list'];
                        $label = $_POST['labelname'];
                        $color = $_POST['textcolor'];
                        $background = $_POST['backgroundcolor'];

                        $params = "name:".$label.",textcolor:".$color.",backgroundcolor:".$background;
                        ActivityFunc::log($current_user->name, $project, $list, "label:add", $params, 0, date("Y-m-d H:i:s"));

                        $label_created_hook = new LabelCreatedHook($project, $list, $label, $color, $background);
                        $plugin_manager->trigger($label_created_hook);

                        LabelFunc::add_label($project, $list, $label, $color, $background);
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
                            $id = clean_input($_POST['id']);
                            $details = LabelFunc::label_details($id);

                            $project = $_POST['project'];
                            $list = $_POST['list'];
                            $label = $_POST['labelname'];
                            $color = $_POST['textcolor'];
                            $background = $_POST['backgroundcolor'];

                            $params = "id:".$id.",name:".$label.",textcolor:".$color.",backgroundcolor:".$background;
                            ActivityFunc::log($current_user->name, $project, $list, "label:edit", $params, 0, date("Y-m-d H:i:s"));

                            $label_modified_hook = new LabelModifiedHook($id, $details['project'], $project, $details['list'], $list, $details['label'], $label, $details['text'], $color, $details['background'], $background);
                            $plugin_manager->trigger($label_modified_hook);

                            LabelFunc::edit_label($id, $project, $list, $label, $color, $background);
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