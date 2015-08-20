<?php

/**
 * Created by Daniel Vidmar.
 * Date: 10/25/14
 * Time: 1:32 AM
 * Version: Beta 2
 * Last Modified: 10/25/14 at 1:32 AM
 * Last Modified by Daniel Vidmar.
 */
$id = 0;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: index.php?".$previous);
}

if(isset($_GET['action']) && $_GET['action'] === "dl") {
    DownloadFunc::download(DownloadFunc::get_id(ProjectFunc::get_id(VersionFunc::get_project($id)), $id));
}

include("include/header.php");
$info = VersionFunc::version_details($id);

$back = "lists.php?page=versions&amp;p=".$project;
$downloads = (VersionFunc::released($id)) ? DownloadFunc::get_downloads(DownloadFunc::get_id($project, $id)) : 0;
$dl_button = (VersionFunc::released($id)) ? '<a href="?id='.$id.'&amp;action=dl"><label class="task-label" style="background:lightgreen;color:darkgreen;border:1px solid darkgreen;">Download</label></a>' : '';

$status_name = "Unreleased";
$status_class = "ip";
if(VersionFunc::released($id)) { $status_name = "Released"; $status_class = "success"; }
if(!VersionFunc::released($id) && $info['due'] !== "0000-00-00" && time() > strtotime($info['due'])) { $status_name = "Overdue"; $status_class = "error"; }

$rules['pages']['version'] = array(
    'back' => $back,
    'status' => array(
        'name' => $status_name,
        'class' => $status_class,
    ),
    'overseer' => ProjectFunc::get_overseer(VersionFunc::get_project($id)),
    'downloads' => $downloads,
    'dlbutton' => $dl_button,
    'progress' => VersionFunc::version_progress($id),
    'name' => $info['name'],
    'project' => $info['project'],
    'due' => $info['due'],
    'released' => $info['released'],
    'type' => $info['type'],
);

$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Version.tpl").'}';
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);