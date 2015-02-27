<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/25/14
 * Time: 6:04 PM
 * Version: Beta 1
 * Last Modified: 4/25/14 at 6:04 PM
 * Last Modified by Daniel Vidmar.
 */
/*
 * Fields
 * name, author, public, mainproject, overseer
 */
if(isset($_POST['add-project'])) {
    if(isset($_POST['name']) && trim($_POST['name']) != "") {
        if(isset($_POST['author']) && trim($_POST['author']) != "") {
            if(isset($_POST['public']) && trim($_POST['public']) != "") {
                if(isset($_POST['mainproject']) && trim($_POST['mainproject']) != "") {
                    if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                        if(!has_values("projects", " WHERE project = '".clean_input($_POST['name'])."'")) {
                            $name = $_POST['name'];
                            $main_project = $_POST['mainproject'];
                            $author = $_POST['author'];
                            $overseer = $_POST['overseer'];
                            $public = $_POST['public'];
                            $created = date("Y-m-d H:i:s");
                            if($main_project != 0) {
                                ProjectFunc::remove_preset();
                            }

                            $project_created_hook = new ProjectCreatedHook($name, $main_project, $author, $overseer);
                            $plugin_manager->trigger($project_created_hook);

                            ProjectFunc::add_project($name, $main_project, 0, $author, $created, $overseer, $public);
                            $params = "public:".$_POST['public'].",overseer:".$_POST['overseer'];
                            ActivityFunc::log($current_user->name, $_POST['name'], "none", "project:add", $params, 0, $created);
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->taken")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nooverseer")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nomain")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nopublic")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noauthor")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noname")).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit-project'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != "") {
        if(isset($_POST['name']) && trim($_POST['name']) != "") {
            if(isset($_POST['public']) && trim($_POST['public']) != "") {
                if(isset($_POST['mainproject']) && trim($_POST['mainproject']) != "") {
                    if(isset($_POST['mainlist']) && trim($_POST['mainlist']) != "") {
                        if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                            $id = $_POST['id'];
                            $details = ProjectFunc::project_details($id);
                            $name = $_POST['name'];
                            if($name == $details['name'] || $name != $details['name'] && !has_values("projects", " WHERE project = '".clean_input($name)."'")) {
                                $main_project = $_POST['mainproject'];
                                $overseer = $_POST['overseer'];
                                $public = $_POST['public'];
                                $created = date("Y-m-d H:i:s");
                                if($details['preset'] == 0 && $main_project == 1) {
                                    ProjectFunc::remove_preset();
                                }
                                if($details['name'] != $name) {
                                    ProjectFunc::rename_project($id, $details['name'], $name);
                                }
                                $params = "id:".$id.",public:".$public.",overseer:".$overseer;
                                ActivityFunc::log($current_user->name, $name, "none", "project:edit", $params, 0, date("Y-m-d H:i:s"));

                                $project_modified_hook = new ProjectModifiedHook($id, $details['name'], $name, $details['preset'], $main_project, $details['overseer'], $overseer);
                                $plugin_manager->trigger($project_modified_hook);

                                ProjectFunc::edit_project($id, $name, $main_project, $_POST['mainlist'], $overseer, $public);
                            } else {
                                echo '<script type="text/javascript">';
                                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->taken")).'");';
                                echo '</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nooverseer")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nomainlist")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nomain")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nopublic")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noname")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}