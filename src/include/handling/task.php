<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/18/14
 * Time: 12:43 PM
 * Version: Beta 1
 * Last Modified: 3/18/14 at 12:43 PM
 * Last Modified by Daniel Vidmar.
 */
/*
 * Fields
 * title, description, author, assignee, due, editable, status, progress, version, labels
 */
if(isset($_POST['add-task'])) {
    if(isset($_POST['title']) && trim($_POST['title']) != "") {
        if(isset($_POST['description']) && trim($_POST['description']) != "") {
            if(isset($_POST['author']) && trim($_POST['author']) != "") {
                if(isset($_POST['editable']) && trim($_POST['editable']) != "") {
                    if(isset($_POST['status']) && trim($_POST['status']) != "") {
                        if(has_values("projects", " WHERE project = '".clean_input($project)."'")) {
                            if(has_values("lists", " WHERE project = '".clean_input($project)."' AND list = '".clean_input($list)."'")) {
                                $title = $_POST['title'];
                                $description = $_POST['description'];
                                $author = $_POST['author'];
                                $assignee = $_POST['assignee'];
                                $created = date("Y-m-d H:i:s");
								$due = (isset($_POST['due-date']) && trim($_POST['due-date']) != "") ? clean_input($_POST['due-date']) : "0000-00-00";
                                $progress = (isset($_POST['progress'])) ? $_POST['progress'] : 0;
                                $labels = (isset($_POST['labels']) && $_POST['labels'] != "") ? $_POST['labels'] : "";
                                $status = $_POST['status'];
                                if($progress > 0) {
                                    ($progress >= 100) ? $status = 1 : $status = 2;
                                }
                                $params = "title:".$_POST['title'].",description:".$_POST['description'].",status:".$status;
                                ActivityFunc::log($current_user->name, $project, $list, "task:add", $params, 0, $created);

                                $task_created_hook = new TaskCreatedHook($project, $list, $title, $description, $author, $assignee, "", $labels, $status, $progress);
                                $plugin_manager->trigger($task_created_hook);

                                TaskFunc::add_task($project, $list, $title, $description, $author, $assignee, $created, $due, "0000-0-00", "", $labels, $_POST['editable'], $status, $progress);
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
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->invalidstatus")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->noeditable")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noauthor")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->nodescription")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->notitle")).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit-task'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != "") {
        if(isset($_POST['title']) && trim($_POST['title']) != "") {
            if(isset($_POST['description']) && trim($_POST['description']) != "") {
                if(isset($_POST['author']) && trim($_POST['author']) != "") {
                    if(isset($_POST['editable']) && trim($_POST['editable']) != "") {
                        if(isset($_POST['status']) && trim($_POST['status']) != "") {
                            if(has_values("projects", " WHERE project = '".clean_input($project)."'")) {
                                if(has_values("lists", " WHERE project = '".clean_input($project)."' AND list = '".clean_input($list)."'")) {
                                    $id = clean_input($_POST['id']);
                                    $details = TaskFunc::task_details($project, $list, $id);

                                    $title = $_POST['title'];
                                    $description = $_POST['description'];
                                    $assignee = $_POST['assignee'];
                                    $created = date("Y-m-d H:i:s");
									$due = (isset($_POST['due-date']) && trim($_POST['due-date']) != "") ? clean_input($_POST['due-date']) : "0000-0-00";
                                    $progress = (isset($_POST['progress'])) ? $_POST['progress'] : 0;
                                    $labels = (isset($_POST['labels-edit']) && $_POST['labels-edit'] != "") ? $_POST['labels-edit'] : "";
                                    $status = $_POST['status'];
                                    if($progress > 0) {
                                        ($progress >= 100) ? $status = 1 : $status = 2;
                                    }

                                    if($status != $details['status']) {
                                        $task_status_hook = new TaskStatusHook($project, $list, $id, $status);
                                        $plugin_manager->trigger($task_status_hook);
                                    }

                                    $params = "id:".$id.",title:".$title.",description:".$description.",status:".$status;
                                    ActivityFunc::log($current_user->name, $project, $list, "task:edit", "", 0, date("Y-m-d H:i:s"));

                                    $task_modified_hook = new TaskModifiedHook($id, $project, $list, $details['title'], $title, $details['description'], $description, $details['assignee'], $assignee, $details['version'], $version, $details['labels'], $labels, $details['status'], $status, $details['progress'], $progress);
                                    $plugin_manager->trigger($task_modified_hook);

                                    TaskFunc::edit_task($id, $project, $list, $title, $description, $_POST['author'], $assignee, $created, $due, "0000-0-00", "", $labels, $_POST['editable'], $status, $progress);
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
                            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->invalidstatus")).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->noeditable")).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->project->noauthor")).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->nodescription")).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->task->notitle")).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replace_shortcuts($language_manager->get_value($language, "site->forms->invalidid")).'");';
        echo '</script>';
    }
}