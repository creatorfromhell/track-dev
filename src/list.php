<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/17/14
 * Time: 1:03 PM
 * Version: Beta 1
 * Last Modified: 3/17/14 at 1:03 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");

if(isset($_POST['add-task'])) {
    $handler = new TaskAddHandler($_POST);
    try {
        $handler->handle();

        $title = $handler->post_vars['title'];
        $description = $handler->post_vars['description'];
        $author = $handler->post_vars['author'];
        $assignee = $handler->post_vars['assignee'];
        $created = date("Y-m-d H:i:s");
        $due = (isset($handler->post_vars['due-date']) && trim($handler->post_vars['due-date']) != "") ? $handler->post_vars['due-date'] : "0000-00-00";
        $progress = (isset($handler->post_vars['progress'])) ? $handler->post_vars['progress'] : 0;
        $labels = (isset($handler->post_vars['labels']) && $handler->post_vars['labels'] != "") ? $handler->post_vars['labels'] : "";
        $status = $handler->post_vars['status'];
        if($progress > 0) {
            ($progress >= 100) ? $status = 1 : $status = 2;
        }
        $params = "title:".$title.",description:".$description.",status:".$status;
        ActivityFunc::log($current_user->name, $project, $list, "task:add", $params, 0, $created);

        $task_created_hook = new TaskCreatedHook($project, $list, $title, $description, $author, $assignee, "", $labels, $status, $progress);
        $plugin_manager->trigger($task_created_hook);

        TaskFunc::add_task($project, $list, $title, $description, $author, $assignee, $created, $due, "0000-0-00", "", $labels, $handler->post_vars['editable'], $status, $progress);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['edit-task'])) {
    $handler = new TaskEditHandler($_POST);
    try {
        $handler->handle();

        $id = $handler->post_vars['id'];
        $details = TaskFunc::task_details($project, $list, $id);

        $title = $handler->post_vars['title'];
        $description = $handler->post_vars['description'];
        $assignee = $handler->post_vars['assignee'];
        $created = date("Y-m-d H:i:s");
        $due = (isset($handler->post_vars['due-date']) && trim($handler->post_vars['due-date']) != "") ? StringFormatter::clean_input($handler->post_vars['due-date']) : "0000-0-00";
        $progress = (isset($handler->post_vars['progress'])) ? $handler->post_vars['progress'] : 0;
        $labels = (isset($handler->post_vars['labels-edit']) && $handler->post_vars['labels-edit'] != "") ? $handler->post_vars['labels-edit'] : "";
        $status = $handler->post_vars['status'];
        if($progress > 0) {
            ($progress >= 100) ? $status = 1 : $status = 2;
        }

        if($status != $details['status']) {
            $task_status_hook = new TaskStatusHook($project, $list, $id, $status);
            $plugin_manager->trigger($task_status_hook);
        }

        $params = "id:".$id.",title:".$title.",description:".$description.",status:".$status;
        ActivityFunc::log($current_user->name, $project, $list, "task:edit", "", 0, date("Y-m-d H:i:s"));

        $task_modified_hook = new TaskModifiedHook($id, $project, $list, $details['title'], $title, $details['description'], $description, $details['assignee'], $assignee, $details['version'], $version, $details['labels'], $labels, $details['status'], $status, $details['progress'], $progress);
        $plugin_manager->trigger($task_modified_hook);

        TaskFunc::edit_task($id, $project, $list, $title, $description, $handler->post_vars['author'], $assignee, $created, $due, "0000-0-00", "", $labels, $handler->post_vars['editable'], $status, $progress);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['add-label'])) {
    $handler = new LabelAddHandler($_POST);
    try {
        $handler->handle();

        $project = $handler->post_vars['project'];
        $list = $handler->post_vars['list'];
        $label = $handler->post_vars['name'];
        $color = $handler->post_vars['color'];
        $background = $handler->post_vars['background'];

        $params = "name:".$label.",color:".$color.",background:".$background;
        ActivityFunc::log($current_user->name, $project, $list, "label:add", $params, 0, date("Y-m-d H:i:s"));

        $label_created_hook = new LabelCreatedHook($project, $list, $label, $color, $background);
        $plugin_manager->trigger($label_created_hook);

        LabelFunc::add_label($project, $list, $label, $color, $background);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['edit-label'])) {
    $handler = new LabelEditHandler($_POST);
    try {
        $handler->handle();

        $id = $handler->post_vars['id'];
        $details = LabelFunc::label_details($id);

        $project = $handler->post_vars['project'];
        $list = $handler->post_vars['list'];
        $label = $handler->post_vars['name'];
        $color = $handler->post_vars['color'];
        $background = $handler->post_vars['background'];

        $params = "id:".$id.",name:".$label.",color:".$color.",background:".$background;
        ActivityFunc::log($current_user->name, $project, $list, "label:edit", $params, 0, date("Y-m-d H:i:s"));

        $label_modified_hook = new LabelModifiedHook($id, $details['project'], $project, $details['list'], $list, $details['label'], $label, $details['text'], $color, $details['background'], $background);
        $plugin_manager->trigger($label_modified_hook);

        LabelFunc::edit_label($id, $project, $list, $label, $color, $background);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

$configs = ListFunc::configurations(ListFunc::get_id($project, $list));
$minimal = ListFunc::minimal(ListFunc::get_id($project, $list));

$switchable = "tasks";
if(isset($_GET['page'])) {
    if($_GET['page'] == 'tasks' || $_GET['page'] == 'labels') {
        $switchable = $_GET['page'];
    }
}
$edit_id = 0;
$editing = false;
if(isset($_GET['action']) && isset($_GET['id']) && can_edit_task(ListFunc::get_id($project, $list), StringFormatter::clean_input($_GET['id']))) {
    $action = $_GET['action'];
    $edit_id = $_GET['id'];

    if($switchable == 'tasks') {
        if($action == "open") {
            $params = "id:".$edit_id.",status:".$action;
            ActivityFunc::log(get_name(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
            $task_status_hook = new TaskStatusHook($project, $list, $edit_id, 0);
            $plugin_manager->trigger($task_status_hook);
            TaskFunc::change_status($project, $list, $edit_id, 0);
            echo '<script type="text/javascript">';
            echo 'showMessage("success", "The status of task #'.$edit_id.' has been changed to open.");';
            echo '</script>';
        } else if($action == "done") {
            $params = "id:".$edit_id.",status:".$action;
            ActivityFunc::log(get_name(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
            $task_status_hook = new TaskStatusHook($project, $list, $edit_id, 1);
            $plugin_manager->trigger($task_status_hook);
            TaskFunc::change_status($project, $list, $edit_id, 1);
            TaskFunc::change_finished($project, $list, $edit_id, date("Y-m-d H:i:s"));
            echo '<script type="text/javascript">';
            echo 'showMessage("success", "The status of task #'.$edit_id.' has been changed to done.");';
            echo '</script>';
        } else if($action == "inprogress") {
            $params = "id:".$edit_id.",status:".$action;
            ActivityFunc::log(get_name(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
            $task_status_hook = new TaskStatusHook($project, $list, $edit_id, 2);
            $plugin_manager->trigger($task_status_hook);
            TaskFunc::change_status($project, $list, $edit_id, 2);
            echo '<script type="text/javascript">';
            echo 'showMessage("success", "The status of task #'.$edit_id.' has been changed to in progress.");';
            echo '</script>';
        } else if($action == "close") {
            $params = "id:".$edit_id.",status:".$action;
            ActivityFunc::log(get_name(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
            $task_status_hook = new TaskStatusHook($project, $list, $edit_id, 3);
            $plugin_manager->trigger($task_status_hook);
            TaskFunc::change_status($project, $list, $edit_id, 3);
            echo '<script type="text/javascript">';
            echo 'showMessage("success", "The status of task #'.$edit_id.' has been changed to closed.");';
            echo '</script>';
        } else if($action == "delete") {
            $params = "id:".$edit_id;
            ActivityFunc::log(get_name(), $project, $list, "task:delete", $params, 0, date("Y-m-d H:i:s"));
            $task_deleted_hook = new TaskDeletedHook($project, $list, $edit_id);
            $plugin_manager->trigger($task_deleted_hook);
            TaskFunc::delete_task($project, $list, $edit_id);
            echo '<script type="text/javascript">';
            echo 'showMessage("success", "Task #'.$edit_id.' has been deleted.");';
            echo '</script>';
        } else if($action == "edit") {
            $editing = true;
        }
    } else if($switchable == 'labels') {
        if($action == "edit") {
            $editing = true;
        } else if($action == "delete") {
            $params = "id:".$edit_id;
            ActivityFunc::log(get_name(), $project, $list, "label:delete", $params, 0, date("Y-m-d H:i:s"));;
            $label_deleted_hook = new LabelDeletedHook($project, $list, $edit_id);
            $plugin_manager->trigger($label_deleted_hook);
            LabelFunc::delete_label($edit_id);
            echo '<script type="text/javascript">';
            echo 'showMessage("success", "Label #'.$edit_id.' has been deleted.");';
            echo '</script>';
        }
    }
}
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "List.tpl").'}';
$rules['pages']['list']['tasks']['style'] = ' ';
$rules['pages']['list']['labels']['style'] = ' ';
$rules['form'] = array(
    'templates' => array(
        'task' => ' ',
        'label'=> ' ',
    ),
);
$rules['table'] = array(
    'templates' => array(
        'tasks' => '<p class="announce">'.$language_manager->get_value($language, "site->tables->missing->tasks").'</p>',
        'labels' => '<p class="announce">'.$language_manager->get_value($language, "site->tables->missing->labels").'</p>',
    ),
);
if($switchable == 'tasks') {
    $rules['site']['header']['h1'] = $language_manager->get_value($language, "site->header");
    $rules['pages']['list']['labels']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-right"><a href="?page=labels">Labels ></a></div>';
    if(is_admin()) {
        $label_values = '';
        $labels = LabelFunc::labels($project, $list);
        foreach($labels as &$label) {
            $label_values .= '<div id="label-'.$label['id'].'" class="draggable-node" style="background:'.$label['background'].';color:'.$label['text'].';border:1px solid '.$label['text'].';" draggable="true" ondragstart="onDrag(event)">'.$label['label'].'</div>';
        }
        $rules['form']['templates']['task'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/TaskAddForm.tpl").'}';
        $rules['form']['content'] = array(
            'user' => $current_user->name,
            'users' => to_options(values("users", "user_name")),
            'versions' => to_options(values("versions", "version_name", " WHERE project = ?", array($project))),
            'labels' => $label_values,
        );
        if($editing) {
            $rules['form']['templates']['task'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/TaskEditForm.tpl").'}';
            $details = TaskFunc::task_details($project, $list, $edit_id);
            $assignee_string = '<option value="none"'.(($details['assignee'] == 'none') ? ' selected' : '').'>None</option>';
            $assignee_string .= to_options(values("users", "user_name"), $details['assignee']);
            $editable_string = '<option value="0"'.(($details['editable'] == 0) ? ' selected' : '').'>No</option>';
            $editable_string .= '<option value="1"'.(($details['editable'] == 1) ? ' selected' : '').'>Yes</option>';
            $status_string = '<option value="0"'.(($details['status'] == 0) ? " selected" : "").'>None</option>';
            $status_string .= '<option value="1"'.(($details['status'] == 1) ? " selected" : "").'>Done</option>';
            $status_string .= '<option value="2"'.(($details['status'] == 2) ? " selected" : "").'>In Progress</option>';
            $status_string .= '<option value="3"'.(($details['status'] == 3) ? " selected" : "").'>Closed</option>';
            $version_string = '<option value="none"'.(($details['version'] == "none") ? " selected" : "").'>None</option>';
            $version_string .= to_options(values("versions", "version_name", " WHERE project = ?", array($project)), $details['version']);
            $labels_string = '';
            $labels_used = '';
            $labels_value = "";
            $labels = LabelFunc::labels($project, $list);
            foreach($labels as &$label) {
                $label_option = '<div id="label-'.$label['id'].'" class="draggable-node" style="background:'.$label['background'].';color:'.$label['text'].';border:1px solid '.$label['text'].';" draggable="true" ondragstart="onDrag(event)">'.$label['label'].'</div>';
                if(!TaskFunc::has_label($project, $list, $id, $label['id'])) {
                    $labels_string .= $label_option;
                } else {
                    $containedLabels .= $label_option;
                    $labels_value .= ($labels_value != "") ? ",".$label['id'] : $label['id'];
                }
            }
            $rules['form']['value'] = array(
                'id' => $edit_id,
                'title' => $details['title'],
                'description' => $details['description'],
                'author' => $details['author'],
                'assignee' => $assignee_string,
                'due' => $details['due'],
                'editable' => $editable_string,
                'status' => $status_string,
                'version' => $version_string,
                'progress' => $details['progress'],
                'labels' => $labels_string,
                'label_values' => $label_values,
                'labels_used' => $labels_used,
            );
        }
    }
} else if($switchable == 'labels') {
    $rules['site']['header']['h1'] = $language_manager->get_value($language, "site->pages->projects->versiontypeheader");
    $rules['pages']['list']['tasks']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-left"><a href="?page=tasks">< Tasks</a></div>';
    if(is_admin()) {
        $rules['form']['templates']['label'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/LabelAddForm.tpl").'}';
        $rules['form']['content'] = array(
            'project' => $project,
            'list' => $list,
        );
        if($editing) {
            $rules['form']['templates']['label'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/LabelEditForm.tpl").'}';
            $details = LabelFunc::label_details($edit_id);
            $rules['form']['value'] = array(
                'id' => $edit_id,
                'project' => $details['project'],
                'list' => $details['list'],
                'label' => $details['label'],
                'text' => $details['text'],
                'background' => $details['background'],
            );
        }
    }
}
$rules['table']['th'] = array(
    'name' => $language_manager->get_value($language, "site->tables->head->name"),
    'assignee' => $language_manager->get_value($language, "site->tables->head->assignee"),
    'created' => $language_manager->get_value($language, "site->tables->head->created"),
    'author' => $language_manager->get_value($language, "site->tables->head->author"),
    'actions' => $language_manager->get_value($language, "site->tables->head->actions"),
);
$rules['table']['pages'] = array(
    'tasks' => ' ',
    'labels' => ' ',
);

global $prefix;
$pagination = new Pagination($prefix."_".$project."_".$list, "id, title, author, assignee, created, editable, task_status", $pn, 10, "?p=".$project."&l=".$list."&page=tasks&", "ORDER BY task_status, id");
if(has_values($project."_".$list) && can_view_list(ListFunc::get_id($project, $list))) {
    $rules['table']['templates']['tasks'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Tasks.tpl").'}';
    $table_content = "";
    $entries = $pagination->paginate_return();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $title = $entry['title'];
        $author = $entry['author'];
        $assignee = $entry['assignee'];
        $created = $entry['created'];
        $editable = $entry['editable'];
        $status = $entry['task_status'];

        if($status == "1") { $table_content .= "<tr class='done'>"; }
        else if($status == "2") { $table_content .= "<tr class='inprogress'>"; }
        else if($status == "3") { $table_content .= "<tr class='closed'>"; }
        else { $table_content .= "<tr>"; }

        $table_content .= "<td class='id'>".$id."</td>";
        $link = "task.php?".$previous."&amp;p=".$project."&amp;l=".$list."&amp;id=".$id;
        $table_content .= "<td class='title'><a href='".$link."'>".$formatter->replace($title)."</a></td>";
        if(!$minimal) {
            $table_content .= "<td class='assignee'>".$formatter->replace($assignee)."</td>";
            $table_content .= "<td class='created'>".$formatter->replace($formatter->format_date($created))."</td>";
            $table_content .= "<td class='author'>".$formatter->replace($author)."</td>";
        }
        $table_content .= "<td class='actions'>";
        if(can_edit_task(ListFunc::get_id($project, $list), $id)) {
            $basic = "p=".$project."&amp;l=".$list."&amp;page=tasks";
            $open = "<a title='Open' class='actionOpen' href='?".$basic."&amp;action=open&amp;id=".$id."'></a>";
            $done = "<a title='Done' class='actionDone' href='?".$basic."&amp;action=done&amp;id=".$id."'></a>";
            $in_progress = "<a title='In Progress' class='actionProgress' href='?".$basic."&amp;action=inprogress&amp;id=".$id."'></a>";
            $close = "<a title='Close' class='actionClose' href='?".$basic."&amp;action=close&amp;id=".$id."'></a>";

            if($status != "0") { $table_content .= $open; }
            if($status != "1") { $table_content .= $done; }
            if($status != "2") { $table_content .= $in_progress; }
            if($status != "3") { $table_content .= $close; }

            $table_content .= "<a title='Edit' class='actionEdit' href='?".$basic."&amp;action=edit&amp;id=".$id."'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete task #".$id."?\");' href='?".$basic."&amp;action=delete&amp;id=".$id."'></a>";
        } else {
            $table_content .= $language_manager->get_value($language, "site->actions->general->none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['tasks'] = $pagination->page_string;
    $rules['table']['content']['tasks'] = $table_content;
}

if(has_values("labels", " WHERE project = ? AND list = ?", array($project, $list))) {
    $rules['table']['templates']['labels'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Labels.tpl").'}';
    $pagination = new Pagination($prefix."_labels", "id, label_name, text_color, background_color", $pn, 10, "?p=".$project."&l=".$list."&page=labels&", "WHERE project = '".$project."' AND list = '".$list."' ORDER BY id");
    $table_content = "";
    $entries = $pagination->paginate_return();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $name = $entry['label_name'];
        $color = $entry['text_color'];
        $background = $entry['background_color'];

        $table_content .= "<tr style='color:".$color.";background:".$background.";'>";
        $table_content .= "<td class='id'>".$id."</td>";
        $table_content .= "<td class='label'>".$formatter->replace($name)."</td>";
        $table_content .= "<td class='actions'>";
        if(can_edit_list(ListFunc::get_id($project, $list))) {
            $basic = "p=".$project."&amp;l=".$list."&amp;page=labels";

            $table_content .= "<a title='Edit' class='actionEdit' href='?".$basic."&amp;action=edit&amp;id=".$id."'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete label #".$id."?\");' href='?".$basic."&amp;action=delete&amp;id=".$id."'></a>";
        } else {
            $table_content .= $language_manager->get_value($language, "site->actions->general->none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['labels'] = $pagination->page_string;
    $rules['table']['content']['labels'] = $table_content;
}
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);