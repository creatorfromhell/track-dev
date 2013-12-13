<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Alpha 1
 * Last Modified: 12/13/13 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("../connect.php");
class TaskFunc {

    //add task
    public static function add($project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("INSERT INTO $t VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssss", $project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete task
    public static function delete($id) {

    }

    //edit task
    public static function edit($id, $project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {

    }

    //change task assignee
    public static function changeAssignee($id, $assignee) {

    }

    //change task labels
    public static function changeLabels($id, $labels) {

    }

    //change task list
    public static function changeList($id, $list) {

    }

    //change task progress
    public static function changeProgress($id, $progress) {

    }

    //change project
    public static function changeProject($id, $project) {

    }

    //change task status
    public static function changeStatus($id, $status) {

    }

    //change task title
    public static function changeTitle($id, $title) {

    }

    //change task version
    public static function changeVersion($id, $version) {

    }
}
?>