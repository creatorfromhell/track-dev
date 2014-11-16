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
    public static function addTask($project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, title, description, author, assignee, due, created, finished, version_name, labels, editable, task_status, progress) VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($title, $description, $author, $assignee, $due, $created, $finish, $version, $labels, $editable, $status, $progress));
    }

    //delete task
    public static function deleteTask($project, $list, $id) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //edit task
    public static function editTask($id, $project, $list, $title, $description, $author, $assignee, $created, $due, $finish, $version, $labels, $editable, $status, $progress) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET title = ?, description = ?, author = ?, assignee = ?, due = ?, created = ?, finished = ?, version_name = ?, labels = ?, editable = ?, task_status = ?, progress = ? WHERE id = ?");
        $stmt->execute($title, $description, $author, $assignee, $due, $created, $finish, $version, $labels, $editable, $status, $progress, $id);
    }

    public static function taskDetails($project, $list, $id) {
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
    public static function changeAssignee($project, $list, $id, $assignee) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET assignee = ? WHERE id = ?");
        $stmt->execute(array($assignee, $id));
    }

    //change task labels
    public static function changeLabels($project, $list, $id, $labels) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET labels = ? WHERE id = ?");
        $stmt->execute(array($labels, $id));
    }

    //change task progress
    public static function changeProgress($project, $list, $id, $progress) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET progress = ? WHERE id = ?");
        $stmt->execute(array($progress, $id));
    }

    public static function changeFinished($project, $list, $id, $finished) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET finished = ? WHERE id = ?");
        $stmt->execute(array($finished, $id));
    }

    //change task status
    public static function changeStatus($project, $list, $id, $status) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET task_status = ? WHERE id = ?");
        $stmt->execute(array($status, $id));
    }

    //change task title
    public static function changeTitle($project, $list, $id, $title) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET title = ? WHERE id = ?");
        $stmt->execute(array($title, $id));
    }

    //change task version
    public static function changeVersion($project, $list, $id, $version) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_name = ? WHERE id = ?");
        $stmt->execute(array($version, $id));
    }

    public static function hasLabel($project, $list, $id, $label) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("SELECT labels FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $labelstring = $result['labels'];
        $labels = explode(',', $labelstring);

        foreach($labels as &$l) {
            if($l != "" && $l == $label) {
                return true;
            }
        }
        return false;
    }

    public static function printAddForm($project, $list, $username) {
        $out = '';
        $out .= '<h3>Add Task</h3>';
        $out .= '<div id="holder">';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input id="title" name="title" type="text" placeholder="Title">';
        $out .= '<textarea id="description" name="description" ROWS="3" COLS="40"></textarea>';
        $out .= '<input id="author" name="author" type="hidden" value="'.$username.'">';
        $out .= '<label for="assignee">Assignee:</label>';
        $out .= '<select name="assignee" id="assignee">';
        $out .= '<option value="none" selected>None</option>';
		$out .= toOptions(users());
        $out .= '</select><br />';
        $out .= '<label for="due-date">Due Date:</label>';
        $out .= '<input id="due-date" name="due-date" type="text" placeholder="0000-00-00" readonly>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_2">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="editable">Editable:</label>';
        $out .= '<select name="editable" id="editable">';
        $out .= '<option value="0">No</option>';
        $out .= '<option value="1" selected>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="status">Status:</label>';
        $out .= '<select name="status" id="status">';
        $out .= '<option value="0" selected>None</option>';
        $out .= '<option value="1">Done</option>';
        $out .= '<option value="2">In Progress</option>';
        $out .= '<option value="3">Closed</option>';
        $out .= '</select><br />';
        $out .= '<label for="version">Version:</label>';
        $out .= '<select name="version" id="version">';
        $out .= '<option value="none" selected>None</option>';
		$out .= toOptions(VersionFunc::versions($project));
        $out .= '</select><br />';
        $out .= '<label for="progress">Progress:<label id="progress_value">0</label></label><br />';
        $out .= '<input type="range" id="progress" name="progress" value="0" min="0" max="100" oninput="showValue(\'progress_value\', this.value);">';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
        $out .= '<button class="submit" onclick="switchPage(event, \'page_2\', \'page_3\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_3">';
        $out .= '<fieldset id="inputs">';
        $out .= '<div class="pick-field">';
        $out .= '<div class="title">Labels</div>';
        $out .= '<div class="column-titles">';
        $out .= '<label class="fmleft">Available</label>';
        $out .= '<label class="fmright">Chosen</label>';
        $out .= '<div class="clear"></div>';
        $out .= '</div>';
        $out .= '<div id="labels-available" class="column-left" ondrop="onDrop(event, \'labels\', \'remove\')" ondragover="onDragOver(event)" style="margin:0;">';
        $labels = LabelFunc::labels($project, $list);
        foreach($labels as &$label) {
            $out .= '<div id="label-'.$label['id'].'" class="draggable-node" style="background:'.$label['background'].';color:'.$label['text'].';border:1px solid '.$label['text'].';" draggable="true" ondragstart="onDrag(event)">'.$label['label'].'</div>';
        }
        $out .= '</div>';
        $out .= '<div id="labels-chosen" class="column-right" ondrop="onDrop(event, \'labels\', \'add\')" ondragover="onDragOver(event)" style="margin:0;height:125px;max-height:125px;overflow-y:scroll;">';
        $out .= '</div>';
        $out .= '<input id="labels-input" name="labels" type="hidden" value="">';
        $out .= '</div>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_3\', \'page_2\'); return false;">Back</button>';
        $out .= '<input type="submit" class="submit" name="add-task" value="Add">';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '</div>';

        return $out;
    }

    public static function printEditForm($project, $list, $id) {
        $details = self::taskDetails($project, $list, $id);

        $out = '';
        $out .= '<h3>Edit Task</h3>';
        $out .= '<div id="holder">';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input name="id" type="hidden" value="'.$id.'">';
        $out .= '<input id="title" name="title" type="text" value="'.$details['title'].'" placeholder="Title">';
        $out .= '<textarea id="description" name="description" ROWS="3" COLS="40">'.$details['description'].'</textarea>';
        $out .= '<input id="author" name="author" type="hidden" value="'.$details['author'].'">';
        $out .= '<label for="assignee">Assignee:</label>';
        $out .= '<select name="assignee" id="assignee">';
        $out .= '<option value="none"'.(($details['assignee'] == 'none') ? ' selected' : '').'>None</option>';
		$out .= toOptions(users(), $details['assignee']);
        $out .= '</select><br />';
        $out .= '<label for="due-date">Due Date:</label>';
        $out .= '<input id="due-date" name="due-date" type="text" value="'.$details['due'].'" readonly>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_2">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="editable">Editable:</label>';
        $out .= '<select name="editable" id="editable">';
        $out .= '<option value="0"'.(($details['editable'] == 0) ? " selected" : "").'>No</option>';
        $out .= '<option value="1"'.(($details['editable'] == 1) ? " selected" : "").'>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="status">Status:</label>';
        $out .= '<select name="status" id="status">';
        $out .= '<option value="0"'.(($details['status'] == 0) ? " selected" : "").'>None</option>';
        $out .= '<option value="1"'.(($details['status'] == 1) ? " selected" : "").'>Done</option>';
        $out .= '<option value="2"'.(($details['status'] == 2) ? " selected" : "").'>In Progress</option>';
        $out .= '<option value="3"'.(($details['status'] == 3) ? " selected" : "").'>Closed</option>';
        $out .= '</select><br />';
        $out .= '<label for="version">Version:</label>';
        $out .= '<select name="version" id="version">';
        $out .= '<option value="none"'.(($details['version'] == "none") ? " selected" : "").'>None</option>';
        $out .= toOptions(VersionFunc::versions($project), $details['version']);
        $out .= '</select><br />';
        $out .= '<label for="progress">Progress:<label id="progress_value">'.$details['progress'].'</label></label><br />';
        $out .= '<input type="range" id="progress" name="progress" value="'.$details['progress'].'" min="0" max="100" oninput="showValue(\'progress_value\', this.value);">';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
        $out .= '<button class="submit" onclick="switchPage(event, \'page_2\', \'page_3\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_3">';
        $out .= '<fieldset id="inputs">';
        $out .= '<div class="pick-field">';
        $out .= '<div class="title">Labels</div>';
        $out .= '<div class="column-titles">';
        $out .= '<label class="fmleft">Available</label>';
        $out .= '<label class="fmright">Chosen</label>';
        $out .= '<div class="clear"></div>';
        $out .= '</div>';
        $out .= '<div id="labels-available-edit" class="column-left" ondrop="onDrop(event, \'labels-edit\', \'remove\')" ondragover="onDragOver(event)" style="margin:0;">';
        $containedLabels = array();
        $labelsValue = "";
        $labels = LabelFunc::labels($project, $list);
        foreach($labels as &$label) {
            $labelString = '<div id="label-'.$label['id'].'" class="draggable-node" style="background:'.$label['background'].';color:'.$label['text'].';border:1px solid '.$label['text'].';" draggable="true" ondragstart="onDrag(event)">'.$label['label'].'</div>';
            if(!self::hasLabel($project, $list, $id, $label['id'])) {
                $out .= $labelString;
            } else {
                $containedLabels[] = $labelString;
                $labelsValue .= ($labelsValue != "") ? ",".$label['id'] : $label['id'];
            }
        }
        $out .= '</div>';
        $out .= '<div id="labels-chosen-edit" class="column-right" ondrop="onDrop(event, \'labels-edit\', \'add\')" ondragover="onDragOver(event)" style="margin:0;height:125px;max-height:125px;overflow-y:scroll;">';
        foreach($containedLabels as &$label) {
            $out .= $label;
        }
        $out .= '</div>';
        $out .= '<input id="labels-input" name="labels-edit" type="hidden" value="'.$labelsValue.'">';
        $out .= '</div>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_3\', \'page_2\'); return false;">Back</button>';
        $out .= '<input type="submit" class="submit" name="edit-task" value="Submit">';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '</div>';

        return $out;
    }
}
?>