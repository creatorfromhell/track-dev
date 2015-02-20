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
 * name, author, project, public, minimal, mainlist, overseer, guestview, guestedit, viewpermission, editpermission
 */
if(isset($_POST['add-list'])) {
    if(isset($_POST['name']) && trim($_POST['name']) != "") {
        if(isset($_POST['author']) && trim($_POST['author']) != "") {
            if(isset($_POST['project']) && trim($_POST['project']) != "") {
                if(isset($_POST['public']) && trim($_POST['public']) != "") {
                    if(isset($_POST['minimal']) && trim($_POST['minimal']) != "") {
                        if(isset($_POST['mainlist']) && trim($_POST['mainlist']) != "") {
                            if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                                if(isset($_POST['guestview']) && trim($_POST['guestview']) != "") {
                                    if(isset($_POST['guestedit']) && trim($_POST['guestedit']) != "") {
                                        if(isset($_POST['viewpermission']) && trim($_POST['viewpermission']) != "") {
                                            if(isset($_POST['editpermission']) && trim($_POST['editpermission']) != "") {
                                                if(has_values("projects", " WHERE project = '".clean_input($_POST['project'])."'")) {
                                                    if(!has_values("lists", " WHERE project = '".clean_input($_POST['project'])."' AND list = '".clean_input($_POST['name'])."'")) {
                                                        $created = date("Y-m-d H:i:s");
                                                        ListFunc::add_list($_POST['name'], $_POST['project'], $_POST['public'], $_POST['author'], $created, $_POST['overseer'], $_POST['minimal'], $_POST['guestview'], $_POST['guestedit'], $_POST['viewpermission'], $_POST['editpermission']);
                                                        ListFunc::create($_POST['project'], $_POST['name']);
                                                        if($_POST['mainlist'] != 0) {
                                                            ProjectFunc::change_main(ProjectFunc::get_id($_POST['project']), ListFunc::get_id($_POST['project'], $_POST['name']));
                                                            $params = "public:".$_POST['public'].",overseer:".$_POST['overseer'];
                                                            ActivityFunc::log($current_user->name, $_POST['project'], $_POST['name'], "list:add", $params, 0, $created);
                                                        }
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("success", "'.$formatter->replace_shortcuts(str_ireplace("%list", $_POST['name'], (string)$language_instance->site->forms->list->created)).'");';
                                                        echo '</script>';
                                                    } else {
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->taken")).'");';
                                                        echo '</script>';
                                                    }
                                                } else {
                                                    echo '<script type="text/javascript">';
                                                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->invalidproject")).'");';
                                                    echo '</script>';
                                                }
                                            } else {
                                                echo '<script type="text/javascript">';
                                                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noeditperm")).'");';
                                                echo '</script>';
                                            }
                                        } else {
                                            echo '<script type="text/javascript">';
                                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noviewperm")).'");';
                                            echo '</script>';
                                        }
                                    } else {
                                        echo '<script type="text/javascript">';
                                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noguestedit")).'");';
                                        echo '</script>';
                                    }
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noguestview")).'");';
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
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->nominimal")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nopublic")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noproject")).'");';
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

if(isset($_POST['edit-list'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != "") {
        if(isset($_POST['name']) && trim($_POST['name']) != "") {
            if(isset($_POST['project']) && trim($_POST['project']) != "") {
                if(isset($_POST['public']) && trim($_POST['public']) != "") {
                    if(isset($_POST['minimal']) && trim($_POST['minimal']) != "") {
                        if(isset($_POST['mainlist']) && trim($_POST['mainlist']) != "") {
                            if(isset($_POST['overseer']) && trim($_POST['overseer']) != "") {
                                if(isset($_POST['guestview']) && trim($_POST['guestview']) != "") {
                                    if(isset($_POST['guestedit']) && trim($_POST['guestedit']) != "") {
                                        if(isset($_POST['viewpermission']) && trim($_POST['viewpermission']) != "") {
                                            if(isset($_POST['editpermission']) && trim($_POST['editpermission']) != "") {
                                                if(has_values("projects", " WHERE project = '".clean_input($_POST['project'])."'")) {
                                                    $id = $_POST['id'];
                                                    $details = ListFunc::list_details($id);
                                                    if($_POST['name'] == $details['name'] || $_POST['name'] != $details['name'] && !has_values("lists", " WHERE project = '".clean_input($_POST['project'])."' AND list = '".clean_input($_POST['name'])."'")) {
                                                        $created = date("Y-m-d H:i:s");
                                                        if($_POST['project'] != $details['project']) {
                                                            ListFunc::change_project($id, $_POST['project']);
                                                        }

                                                        if($_POST['name'] != $details['name']) {
                                                            ListFunc::rename_list($id, $_POST['name']);
                                                        }

                                                        if(ProjectFunc::get_main(ProjectFunc::get_id($details['project'])) != $id && $_POST['mainlist'] == 1) {
                                                            ProjectFunc::change_main(ProjectFunc::get_id($_POST['project']), ListFunc::get_id($_POST['project'], $_POST['name']));
                                                        }
                                                        ListFunc::edit_list($id, $_POST['name'], $_POST['project'], $_POST['public'], $_POST['overseer'], $_POST['minimal'], $_POST['guestview'], $_POST['guestedit'], $_POST['viewpermission'], $_POST['editpermission']);
                                                        $params = "id:".$id.",public:".$_POST['public'].",overseer:".$_POST['overseer'];
                                                        ActivityFunc::log($current_user->name, $_POST['project'], $_POST['name'], "list:edit", $params, 0, $created);
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("success", "'.$formatter->replace_shortcuts(str_ireplace("%list", $_POST['name'], (string)$language_instance->site->forms->list->created)).'");';
                                                        echo '</script>';
                                                    } else {
                                                        echo '<script type="text/javascript">';
                                                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->taken")).'");';
                                                        echo '</script>';
                                                    }
                                                } else {
                                                    echo '<script type="text/javascript">';
                                                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->invalidproject")).'");';
                                                    echo '</script>';
                                                }
                                            } else {
                                                echo '<script type="text/javascript">';
                                                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noeditperm")).'");';
                                                echo '</script>';
                                            }
                                        } else {
                                            echo '<script type="text/javascript">';
                                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noviewperm")).'");';
                                            echo '</script>';
                                        }
                                    } else {
                                        echo '<script type="text/javascript">';
                                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noguestedit")).'");';
                                        echo '</script>';
                                    }
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noguestview")).'");';
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
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->nominimal")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->nopublic")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->list->noproject")).'");';
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