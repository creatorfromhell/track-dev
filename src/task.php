<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/25/14
 * Time: 9:44 PM
 * Version: Beta 1
 * Last Modified: 4/25/14 at 9:44 PM
 * Last Modified by Daniel Vidmar.
 */
$id = 0;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: index.php");
}
include("include/header.php");

$back = "list.php?p=".$project."&l=".$list;
$task_details = TaskFunc::taskDetails($project, $list, $id);

$finished = ($task_details['finished'] != "0000-00-00") ? $task_details['finished'] : "None";
$due = ($task_details['due'] != "0000-00-00") ? $task_details['due'] : "None";
$version = ($task_details['version'] != "") ? $task_details['version'] : "None";
$progress = $task_details['progress']."%";
$status = $task_details['status'];
$status_name = "Open";
$status_class = "general";
if($status == "0") { $status_name = "Open"; $status_class = "general"; }
if($status == "1") { $status_name = "Done"; $status_class = "success"; }
if($status == "2") { $status_name = "In Progress"; $status_class = "ip"; }
if($status == "3") { $status_name = "Closed"; $status_class = "error"; }
$labels_string = '';
$labels_array = explode(",", $task_details['labels']);
foreach($labels_array as &$label) {
    $label_details = LabelFunc::labelDetails($label);
    $labels_string .= '<label class="task-label" style="background:'.$label_details['background'].';color:'.$label_details['text'].';border:1px solid '.$label_details['text'].';">'.$label_details['label'].'</label>';
}

$rules['pages']['task'] = array(
    'back' => $back,
    'title' => $task_details['title'],
    'status' => array(
        'name' => $status_name,
        'class' => $status_class,
    ),
    'progress' => $task_details['progress'].'%',
    'author' => $task_details['author'],
    'created' => $task_details['created'],
    'assignee' => $task_details['assignee'],
    'version' => $version,
    'due' => $due,
    'finished' => $finished,
    'description' => $task_details['description'],
    'labels' => $labels_string,
);
$rules['site']['page']['content'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "Task.tpl").'}';
new SimpleTemplate($theme_manager->GetTemplate((string)$theme->name, "basic/Page.tpl"), $rules, true);