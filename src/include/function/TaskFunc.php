<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */
class TaskFunc {

    //add task
    /**
     * @param $project
     * @param $list
     * @param $title
     * @param $description
     * @param $author
     * @param $assignee
     * @param $created
     * @param $due
     * @param $finish
     * @param $version
     * @param $labels
     * @param $editable
     * @param $status
     * @param $progress
     */
    public static function add_task($project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, title, description, author, assignee, due, created, finished, version_name, labels, editable, task_status, progress) VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($title, $description, $author, $assignee, $due, $created, $finish, $version, $labels, $editable, $status, $progress));
    }

    //delete task
    /**
     * @param $project
     * @param $list
     * @param $id
     */
    public static function delete_task($project, $list, $id) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //edit task
    /**
     * @param $id
     * @param $project
     * @param $list
     * @param $title
     * @param $description
     * @param $author
     * @param $assignee
     * @param $created
     * @param $due
     * @param $finish
     * @param $version
     * @param $labels
     * @param $editable
     * @param $status
     * @param $progress
     */
    public static function edit_task($id, $project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET title = ?, description = ?, author = ?, assignee = ?, due = ?, created = ?, finished = ?, version_name = ?, labels = ?, editable = ?, task_status = ?, progress = ? WHERE id = ?");
        $stmt->execute($title, $description, $author, $assignee, $due, $created, $finish, $version, $labels, $editable, $status, $progress, $id);
    }

    /**
     * @param $project
     * @param $list
     * @param $id
     * @return array
     */
    public static function task_details($project, $list, $id) {
        $return = array();
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("SELECT title, description, author, assignee, due, created, finished, version_name, labels, editable, task_status, progress FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $return['title'] = $result['title'];
        $return['description'] = $result['description'];
        $return['author'] = $result['author'];
        $return['assignee'] = $result['assignee'];
        $return['due'] = $result['due'];
        $return['created'] = $result['created'];
        $return['finished'] = $result['finished'];
        $return['version'] = $result['version_name'];
        $return['labels'] = $result['labels'];
        $return['editable'] = $result['editable'];
        $return['status'] = $result['task_status'];
        $return['progress'] = $result['progress'];
        return $return;
    }

    //change task assignee
    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $assignee
     */
    public static function change_assignee($project, $list, $id, $assignee) {
        set_value($project."_".$list, "assignee", $assignee, " WHERE id = ?", array($id));
    }

    //change task labels
    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $labels
     */
    public static function change_labels($project, $list, $id, $labels) {
        set_value($project."_".$list, "labels", $labels, " WHERE id = ?", array($id));
    }

    //change task progress
    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $progress
     */
    public static function change_progress($project, $list, $id, $progress) {
        set_value($project."_".$list, "progress", $progress, " WHERE id = ?", array($id));
    }

    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $finished
     */
    public static function change_finished($project, $list, $id, $finished) {
        set_value($project."_".$list, "finished", $finished, " WHERE id = ?", array($id));
    }

    //change task status
    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $status
     */
    public static function change_status($project, $list, $id, $status) {
        set_value($project."_".$list, "task_status", $status, " WHERE id = ?", array($id));
    }

    //change task title
    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $title
     */
    public static function change_title($project, $list, $id, $title) {
        set_value($project."_".$list, "title", $title, " WHERE id = ?", array($id));
    }

    //change task version
    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $version
     */
    public static function change_version($project, $list, $id, $version) {
        set_value($project."_".$list, "version_name", $version, " WHERE id = ?", array($id));
    }

    /**
     * @param $project
     * @param $list
     * @param $id
     * @param $label
     * @return bool
     */
    public static function has_label($project, $list, $id, $label) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("SELECT labels FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $label_string = $result['labels'];
        $labels = explode(',', $label_string);

        foreach($labels as &$l) {
            if($l != "" && $l == $label) {
                return true;
            }
        }
        return false;
    }
}