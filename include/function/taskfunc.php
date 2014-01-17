<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("../connect.php");
class TaskFunc {

    //add task
    public static function add($project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
		//TODO: Decide how to store tasks i.e. per list table or 1 table sorted by project & list
    }

    //delete task
    public static function delete($id) {

    }

    //edit task
    public static function edit($id, $project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {

    }

    //change task assignee
    public static function changeAssignee($project, $list, $id, $assignee) {

    }

    //change task labels
    public static function changeLabels($project, $list, $id, $labels) {

    }

    //change task list
    public static function changeList($project, $list, $id, $list) {

    }

    //change task progress
    public static function changeProgress($project, $list, $id, $progress) {

    }

    //change project
    public static function changeProject($project, $list, $id, $project) {

    }

    //change task status
    public static function changeStatus($project, $list, $id, $status) {

    }

    //change task title
    public static function changeTitle($project, $list, $id, $title) {

    }

    //change task version
    public static function changeVersion($project, $list, $id, $version) {

    }
}
?>