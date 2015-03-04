<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/21/14
 * Time: 2:11 PM
 * Version: Beta 1
 * Last Modified: 3/21/14 at 2:11 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");

if(isset($_POST['add-list'])) {
    $handler = new ListAddHandler($_POST);
    try {
        $list = $handler->post_vars['name'];
        $project = $handler->post_vars['project'];
        $public = $handler->post_vars['public'];
        $author = $handler->post_vars['author'];
        $overseer = $handler->post_vars['overseer'];
        $created = date("Y-m-d H:i:s");

        $params = "public:".$public.",overseer:".$overseer;
        ActivityFunc::log($current_user->name, $project, $list, "list:add", $params, 0, $created);

        $list_created_hook = new ListCreatedHook($project, $list, $author, $overseer);
        $plugin_manager->trigger($list_created_hook);

        ListFunc::add_list($list, $project, $public, $author, $created, $overseer, $handler->post_vars['minimal'], $handler->post_vars['guestview'], $handler->post_vars['guestedit'], $handler->post_vars['viewpermission'], $handler->post_vars['editpermission']);
        ListFunc::create($project, $list);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['edit-list'])) {
    $handler = new ListEditHandler($_POST);
    try {
        $id = $handler->post_vars['id'];
        $details = ListFunc::list_details($id);

        $list = $handler->post_vars['name'];
        $project = $handler->post_vars['project'];
        $public = $handler->post_vars['public'];
        $overseer = $handler->post_vars['overseer'];

        $params = "id:".$id.",public:".$public.",overseer:".$overseer;
        ActivityFunc::log($current_user->name, $project, $list, "list:edit", $params, 0, date("Y-m-d H:i:s"));

        $list_modified_hook = new ListModifiedHook($id, $details['project'], $project, $details['list'], $list, $details['overseer'], $overseer);
        $plugin_manager->trigger($list_modified_hook);

        ListFunc::edit_list($id, $list, $project, $public, $overseer, $handler->post_vars['minimal'], $handler->post_vars['guestview'], $handler->post_vars['guestedit'], $handler->post_vars['viewpermission'], $handler->post_vars['editpermission']);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['add-version'])) {
    $handler = new VersionAddHandler($_POST);
    try {
        $version = $handler->post_vars['version-name'];
        $project = $handler->post_vars['project'];
        $status = $handler->post_vars['status'];
        $type = $handler->post_vars['version-type'];
        $due = (isset($handler->post_vars['due-date']) && trim($handler->post_vars['due-date']) != "") ? $handler->post_vars['due-date'] : "0000-00-00";

        $version_created_hook = new VersionCreatedHook($project, $version, $status, $type);
        $plugin_manager->trigger($version_created_hook);

        VersionFunc::add_version($version, $project, $status, $due, '0000-00-00', $type);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['edit-version'])) {
    $handler = new VersionEditHandler($_POST);
    try {
        $id = $handler->post_vars['id'];
        $details = VersionFunc::version_details($id);

        $version = $handler->post_vars['version-name'];
        $project = $handler->post_vars['project'];
        $status = $handler->post_vars['status'];
        $type = $handler->post_vars['version-type'];
        $due = (isset($handler->post_vars['due-date']) && trim($handler->post_vars['due-date']) != "") ? $handler->post_vars['due-date'] : "0000-00-00";

        $version_modified_hook = new VersionModifiedHook($id, $details['project'], $project, $details['name'], $version, $details['status'], $status, $details['type'], $type);
        $plugin_manager->trigger($version_modified_hook);

        VersionFunc::edit_version($id, $version, $project, $status, $due, '0000-00-00', $type);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

$switchable = "lists";
if(isset($_GET['page'])) {
    if($_GET['page'] == 'lists' || $_GET['page'] == 'versions') {
        $switchable = $_GET['page'];
    }
}
$edit_id = 0;
$editing = false;
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = StringFormatter::clean_input($_GET['action']);
    $edit_id = StringFormatter::clean_input($_GET['id']);
    if(is_admin() || ProjectFunc::get_overseer($project) == get_name()) {
        if($switchable == "lists") {
            if($action == "delete") {
                $name = ListFunc::get_name($edit_id);
                $params = "id:".$edit_id;
                ActivityFunc::log(get_name(), $project, $name, "list:delete", $params, 0, date("Y-m-d H:i:s"));
                $list_deleted_hook = new ListDeletedHook($project, $edit_id);
                $plugin_manager->trigger($list_deleted_hook);
                ListFunc::remove($edit_id);
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "List '.$name.' has been deleted.");';
                echo '</script>';
            } else if($action == "edit") {
                $editing = true;
            }
        } else if($switchable == "versions") {
            if($action == "delete") {
                $version_deleted_hook = new VersionDeletedHook($project, $edit_id);
                $plugin_manager->trigger($version_deleted_hook);
                VersionFunc::delete_version($edit_id);
            } else if($action == "edit") {
                $editing = true;
            }
        }
    }
}
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Lists.tpl").'}';
$rules['pages']['lists']['lists']['style'] = ' ';
$rules['pages']['lists']['versions']['style'] = ' ';
$rules['form'] = array(
    'templates' => array(
        'list' => ' ',
        'version'=> ' ',
    ),
);
$rules['table'] = array(
    'templates' => array(
        'lists' => '<p class="announce">'.$language_manager->get_value($language, "site->tables->missing->lists").'</p>',
        'versions' => '<p class="announce">'.$language_manager->get_value($language, "site->tables->missing->versions").'</p>',
    ),
);
if($switchable == 'lists') {
    $rules['site']['header']['h1'] = $language_manager->get_value($language, "site->pages->lists->header");
    $rules['site']['header']['h1'] = $language_manager->get_value($language, "site->pages->lists->header");
    $rules['pages']['lists']['versions']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-right"><a href="?page=versions">Versions ></a></div>';
    if(is_admin()) {
        $node_values = '';
        $nodes = values("nodes", "node_name");
        foreach($nodes as &$node) {
            $node_values .= '<option value="'.node_id($node).'">'.$node.'</option>';
        }
        $rules['form']['templates']['list'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/ListAddForm.tpl").'}';
        $rules['form']['content'] = array(
            'user' => $current_user->name,
            'projects' => to_options($projects, $project),
            'users' => to_options(values("users", "user_name")),
            'nodes' => $node_values,
        );
        if($editing) {
            $rules['form']['templates']['list'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/ListEditForm.tpl").'}';
            $details = ListFunc::list_details($edit_id);
            $main = ProjectFunc::get_main_list($details['project']);
            $public_string = '<option value="0"'.(($details['public'] == 0) ? ' selected' : '').'>No</option>';
            $public_string .= '<option value="1"'.(($details['public'] == 1) ? ' selected' : '').'>Yes</option>';
            $minimal_string = '<option value="0"'.((!ListFunc::minimal($edit_id)) ? ' selected' : '').'>No</option>';
            $minimal_string .= '<option value="1"'.((ListFunc::minimal($edit_id)) ? ' selected' : '').'>Yes</option>';
            $main_string = '<option value="0"'.(($main != $id) ?' selected' : '').'>No</option>';
            $main_string .= '<option value="1"'.(($main == $id) ? ' selected' : '').'>Yes</option>';
            $overseer_string = '<option value="none"'.(($details['overseer'] == 'none') ? ' selected' : '').'>None</option>';
            $overseer_string .= to_options(values("users", "user_name"), $details['overseer']);
            $guest_view = '<option value="0"'.((ListFunc::guest_permissions($edit_id)['view'] == 0) ? ' selected' : '').'>No</option>';
            $guest_view .= '<option value="1"'.((ListFunc::guest_permissions($edit_id)['view'] == 1) ? ' selected' : '').'>Yes</option>';
            $guest_edit = '<option value="0"'.((ListFunc::guest_permissions($edit_id)['edit'] == 0) ?' selected' : '').'>No</option>';
            $guest_edit .= '<option value="1"'.((ListFunc::guest_permissions($edit_id)['edit'] == 1) ? ' selected' : '').'>Yes</option>';
            $view_permission = '<option value="none"'.((ListFunc::view_permission($id) == 'none') ? ' selected' : '').'>None</option>';
            $edit_permission = '<option value="none"'.((ListFunc::edit_permission($id) == 'none') ? ' selected' : '').'>None</option>';
            $nodes = values("nodes", "node_name");
            foreach($nodes as &$node) {
                $view_permission .= '<option value="'.node_id($node).'"'.((ListFunc::view_permission($id) == $node) ? ' selected' : '').'>'.$node.'</option>';
                $edit_permission .= '<option value="'.node_id($node).'"'.((ListFunc::edit_permission($id) == $node) ? ' selected' : '').'>'.$node.'</option>';
            }
            $rules['form']['value'] = array(
                'id' => $edit_id,
                'name' => $details['name'],
                'project' => to_options(values("projects", "project"), $details['project']),
                'public' => $public_string,
                'minimal' => $minimal_string,
                'main' => $main_string,
                'overseer' => $overseer_string,
                'guest_view' => $guest_view,
                'guest_edit' => $guest_edit,
                'view_permission' => $view_permission,
                'edit_permission' => $edit_permission,
            );
        }
    }
} else if($switchable == 'versions') {
    $rules['site']['header']['h1'] = $language_manager->get_value($language, "site->pages->lists->versionsheader");
    $rules['pages']['lists']['lists']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-left"><a href="?page=lists">< Lists</a></div>';
    if(is_admin()) {
        $rules['form']['templates']['version'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/VersionAddForm.tpl").'}';
        $rules['form']['content'] = array(
            'project' => $project,
            'types' => to_options(values("version_types", "version_type")),
        );
        if($editing) {
            $rules['form']['templates']['version'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/VersionEditForm.tpl").'}';
            $details = VersionFunc::version_details($edit_id);
            $status_string = '<option value="0"'.(($details['status'] == '0') ? ' selected' : '').'>None</option>';
            $status_string .= '<option value="1"'.(($details['status'] == '1') ? ' selected' : '').'>Upcoming</option>';
            $status_string .= '<option value="2"'.(($details['status'] == '2') ? ' selected' : '').'>Released</option>';
            $type_string = '<option value="none"'.(($details['type'] == 'none') ? ' selected' : '').'>None</option>';
            $type_string .= to_options(values("version_types", "version_type"), $details['type']);
            $rules['form']['value'] = array(
                'id' => $edit_id,
                'project' => $details['project'],
                'name' => $details['name'],
                'status' => $status_string,
                'type' => $type_string,
                'due' => $details['due'],
            );
        }
    }
}
$rules['table']['th'] = array(
    'name' => $language_manager->get_value($language, "site->tables->head->name"),
    'created' => $language_manager->get_value($language, "site->tables->head->created"),
    'creator' => $language_manager->get_value($language, "site->tables->head->creator"),
    'overseer' => $language_manager->get_value($language, "site->tables->head->overseer"),
    'actions' => $language_manager->get_value($language, "site->tables->head->actions"),
    'stable' => $language_manager->get_value($language, "site->tables->head->stable"),
    'type' => $language_manager->get_value($language, "site->tables->head->type"),
);
$rules['table']['pages'] = array(
    'lists' => ' ',
    'versions' => ' ',
);

global $prefix;
$pagination = new Pagination($prefix."_lists", "id, list, created, creator, overseer", $pn, 10, "?p=".$project."&page=lists&", "WHERE `project` = '".$project."'");
if(has_values("lists", " WHERE project = ?", array($project))) {
    $rules['table']['templates']['lists'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Lists.tpl").'}';
    $table_content = "";
    $entries = $pagination->paginate_return();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $name = $entry['list'];
        $created = $entry['created'];
        $creator = $entry['creator'];
        $overseer = $entry['overseer'];

        $table_content .= "<tr>";
        $table_content .= "<td class='name'><a href='list.php?p=".$project."&amp;l=".$name."'>".$formatter->replace($name)."</a></td>";
        $table_content .= "<td class='created'>".$formatter->replace($formatter->format_date($created))."</td>";
        $table_content .= "<td class='creator'>".$formatter->replace($creator)."</td>";
        $table_content .= "<td class='overseer'>".$formatter->replace($overseer)."</td><td>";
        if(is_admin() || ProjectFunc::get_overseer($project) == get_name()) {
            $table_content .= "<a title='Edit' class='actionEdit' href='?p=".$project."&amp;page=lists&amp;action=edit&amp;id=".$id."'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete list ".$name."?\");' href='?p=".$project."&amp;action=delete&amp;id=".$id."'></a>";
        } else {
            $table_content .= $language_manager->get_value($language, "site->actions->general->none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['lists'] = $pagination->page_string;
    $rules['table']['content']['lists'] = $table_content;
}

if(has_values("versions", " WHERE project = ?", array($project))) {
    $rules['table']['templates']['versions'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Versions.tpl").'}';
    $pagination = new Pagination($prefix."_versions", "id, version_name, version_status, version_type", $pn, 10);
    $table_content = "";
    $entries = $pagination->paginate_return();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $name = $entry['version_name'];
        $type = $entry['version_type'];
        $stable = (VersionFunc::stable($entry['version_type'])) ? 'Yes' : 'No';

        $table_content .= "<tr>";
        $table_content .= "<td class='name'><a href='#'>".$formatter->replace($name)."</a></td>";
        $table_content .= "<td class='type'>".$formatter->replace($type)."</td>";
        $table_content .= "<td class='stable'>".$formatter->replace($stable)."</td>";
        $table_content .= "<td class='actions'>";
        if(is_admin()) {
            $table_content .= "<a title='Edit' class='actionEdit' href='?action=edit&amp;id=".$id."&amp;page=versions'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete version ".$name."?\");' href='?action=delete&amp;id=".$id."&amp;page=versions'></a>";
        } else {
            $table_content .= $language_manager->get_value($language, "site->actions->general->none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['versions'] = $pagination->page_string;
    $rules['table']['content']['versions'] = $table_content;
}
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);