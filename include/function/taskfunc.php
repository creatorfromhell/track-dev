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
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, title, description, author, assignee, due, created, finished, versionname, labels, editable, taskstatus, progress) VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $author);
        $stmt->bindParam(4, $assignee);
        $stmt->bindParam(5, $due);
        $stmt->bindParam(6, $created);
        $stmt->bindParam(7, $finish);
        $stmt->bindParam(8, $version);
        $stmt->bindParam(9, $labels);
        $stmt->bindParam(10, $editable);
        $stmt->bindParam(11, $status);
        $stmt->bindParam(12, $progress);
        $stmt->execute();
    }

    //delete task
    public static function delete($project, $list, $id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
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
        $stmt = $c->prepare("UPDATE `".$t."` SET title = ?, description = ?, author = ?, assignee = ?, due = ?, created = ?, finished = ?, versionname = ?, labels = ?, editable = ?, taskstatus = ?, progress = ? WHERE id = ?");
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $author);
        $stmt->bindParam(4, $assignee);
        $stmt->bindParam(5, $due);
        $stmt->bindParam(6, $created);
        $stmt->bindParam(7, $finish);
        $stmt->bindParam(8, $version);
        $stmt->bindParam(9, $labels);
        $stmt->bindParam(10, $editable);
        $stmt->bindParam(11, $status);
        $stmt->bindParam(12, $progress);
        $stmt->bindParam(13, $id);
        $stmt->execute();
    }

    //change task assignee
    public static function changeAssignee($project, $list, $id, $assignee) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("UPDATE `".$t."` SET assignee = ? WHERE id = ?");
        $stmt->bindParam(1, $assignee);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change task labels
    public static function changeLabels($project, $list, $id, $labels) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("UPDATE `".$t."` SET labels = ? WHERE id = ?");
        $stmt->bindParam(1, $labels);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change task list
    public static function changeList($project, $list, $id, $newList) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        //use INTO SELECT
    }

    //change task progress
    public static function changeProgress($project, $list, $id, $progress) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("UPDATE `".$t."` SET progress = ? WHERE id = ?");
        $stmt->bindParam(1, $progress);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change project
    public static function changeProject($project, $list, $id, $newProject) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        //use INTO SELECT
    }

    public static function changeFinished($project, $list, $id, $finished) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("UPDATE `".$t."` SET finished = ? WHERE id = ?");
        $stmt->bindParam(1, $finished);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change task status
    public static function changeStatus($project, $list, $id, $status) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("UPDATE `".$t."` SET taskstatus = ? WHERE id = ?");
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change task title
    public static function changeTitle($project, $list, $id, $title) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("UPDATE `".$t."` SET title = ? WHERE id = ?");
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change task version
    public static function changeVersion($project, $list, $id, $version) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("UPDATE `".$t."` SET versionname = ? WHERE id = ?");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }
}
?>