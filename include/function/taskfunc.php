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
require_once("include/connect.php");
class TaskFunc {

    //add task
    public static function add($project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //delete task
    public static function delete($project, $list, $id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //check task table
    public static function checkTable($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //edit task
    public static function edit($id, $project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change task assignee
    public static function changeAssignee($project, $list, $id, $assignee) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change task labels
    public static function changeLabels($project, $list, $id, $labels) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change task list
    public static function changeList($project, $list, $id, $newList) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change task progress
    public static function changeProgress($project, $list, $id, $progress) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change project
    public static function changeProject($project, $list, $id, $newProject) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change task status
    public static function changeStatus($project, $list, $id, $status) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change task title
    public static function changeTitle($project, $list, $id, $title) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }

    //change task version
    public static function changeVersion($project, $list, $id, $version) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
    }
}
?>