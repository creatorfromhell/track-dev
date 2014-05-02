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
                if(isset($_POST['assignee']) && trim($_POST['assignee']) != "") {
                    if(isset($_POST['due']) && trim($_POST['due']) != "") {
                        if(isset($_POST['editable']) && trim($_POST['editable']) != "") {
                            if(isset($_POST['status']) && trim($_POST['status']) != "") {
                                if(isset($_POST['progress']) && trim($_POST['progress']) != "") {
                                    if(isset($_POST['version']) && trim($_POST['version']) != "") {
                                        if(isset($_POST['labels']) && trim($_POST['labels']) != "") {
                                            $created = date("Y-m-d H:i:s");
                                            TaskFunc::add($project, $list, $_POST['title'], $_POST['description'], $_POST['author'], $_POST['assignee'], $created, $_POST['due'], 0, $_POST['version'], $_POST['labels'], $_POST['editable'], $_POST['status'], $_POST['progress']);
                                        } else {

                                        }
                                    } else {

                                    }
                                } else {

                                }
                            } else {

                            }
                        } else {

                        }
                    } else {

                    }
                } else {

                }
            } else {

            }
        } else {

        }
    } else {

    }
}

if(isset($_POST['edit'])) {

}
?>