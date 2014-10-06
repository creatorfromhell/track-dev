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
if(isset($_POST['add'])) {
    if(isset($_POST['title']) && trim($_POST['title']) != "") {
        if(isset($_POST['description']) && trim($_POST['description']) != "") {
            if(isset($_POST['author']) && trim($_POST['author']) != "") {
                if(isset($_POST['editable']) && trim($_POST['editable']) != "") {
                    if(isset($_POST['status']) && trim($_POST['status']) != "") {
                        if(ProjectFunc::exists($project)) {
                            if(ListFunc::exists($project, $list)) {
                                $created = date("Y-m-d H:i:s");
                                $progress = (isset($_POST['progress'])) ? $_POST['progress'] : 0;
                                $labels = (isset($_POST['labels']) && $_POST['labels'] != "") ? $_POST['labels'] : "";
                                $status = $_POST['status'];
                                if($progress > 0) {
                                    ($progress >= 100) ? $status = 1 : $status = 2;
                                }
                                TaskFunc::add($project, $list, $_POST['title'], $_POST['description'], $_POST['author'], $_POST['assignee'], $created, "0000-0-00", "0000-0-00", "", $labels, $_POST['editable'], $status, $progress);
                                $params = "title:".$_POST['title'].",description:".$_POST['description'].",status:".$status;
                                ActivityFunc::log($currentUser->name, $project, $list, "task:add", $params, 0, $created);
                            } else {
                                echo '<script type="text/javascript">';
                                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->invalidlist)).'");';
                                echo '</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->invalidproject)).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->invalidstatus)).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->noeditable)).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noauthor)).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->nodescription)).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->notitle)).'");';
        echo '</script>';
    }
}

if(isset($_POST['edit'])) {
    if(isset($_POST['id']) && trim($_POST['id']) != "") {
        if(isset($_POST['title']) && trim($_POST['title']) != "") {
            if(isset($_POST['description']) && trim($_POST['description']) != "") {
                if(isset($_POST['author']) && trim($_POST['author']) != "") {
                    if(isset($_POST['editable']) && trim($_POST['editable']) != "") {
                        if(isset($_POST['status']) && trim($_POST['status']) != "") {
                            if(ProjectFunc::exists($project)) {
                                if(ListFunc::exists($project, $list)) {
                                    $created = date("Y-m-d H:i:s");
                                    $progress = (isset($_POST['progress'])) ? $_POST['progress'] : 0;
                                    $labels = (isset($_POST['labels-edit']) && $_POST['labels-edit'] != "") ? $_POST['labels-edit'] : "";
                                    $status = $_POST['status'];
                                    if($progress > 0) {
                                        ($progress >= 100) ? $status = 1 : $status = 2;
                                    }
                                    TaskFunc::edit($_POST['id'], $project, $list, $_POST['title'], $_POST['description'], $_POST['author'], $_POST['assignee'], $created, "0000-0-00", "0000-0-00", "", $labels, $_POST['editable'], $status, $progress);
                                    $params = "id:".$_POST['id'].",title:".$_POST['title'].",description:".$_POST['description'].",status:".$status;
                                    ActivityFunc::log($currentUser->name, $project, $list, "task:edit", "", 0, date("Y-m-d H:i:s"));
                                } else {
                                    echo '<script type="text/javascript">';
                                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->invalidlist)).'");';
                                    echo '</script>';
                                }
                            } else {
                                echo '<script type="text/javascript">';
                                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->list->invalidproject)).'");';
                                echo '</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->invalidstatus)).'");';
                            echo '</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">';
                        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->noeditable)).'");';
                        echo '</script>';
                    }
                } else {
                    echo '<script type="text/javascript">';
                    echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->project->noauthor)).'");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->nodescription)).'");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->task->notitle)).'");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'showMessage("error", "'.$formatter->replaceShortcuts(((string)$languageinstance->site->forms->invalidid)).'");';
        echo '</script>';
    }
}
?>