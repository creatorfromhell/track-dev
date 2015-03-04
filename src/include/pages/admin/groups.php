<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 6:53 PM
 * Version: Beta 1
 * Last Modified: 8/7/14 at 6:53 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['add-group'])) {
    $handler = new GroupAddHandler($_POST);
    try {
        $handler->handle();

        $group = new Group();
        $group->name = $handler->post_vars['name'];
        $group->admin = ($handler->post_vars['admin'] == '1') ? true : false;
        $group->preset = ($handler->post_vars['preset'] == '1') ? true : false;
        $group->permissions = explode(",", $handler->post_vars['permissions-value']);

        $params = "name:".$group->name.",admin:".$group->admin.",preset:".$group->preset;
        ActivityFunc::log($current_user->name, "none", "none", "group:add", $params, 0, date("Y-m-d H:i:s"));

        $group_created_hook = new GroupCreatedHook($group->name, $group->admin, $group->preset, $group->permissions);
        $plugin_manager->trigger($group_created_hook);

        Group::add_group($group);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['edit-group'])) {
    $handler = new GroupEditHandler($_POST);
    try {
        $handler->handle();

        $name = $handler->post_vars['name'];
        $admin = ($handler->post_vars['admin'] == '1') ? true : false;
        $preset = ($handler->post_vars['preset'] == '1') ? true : false;
        $permissions = explode(",", $handler->post_vars['permissions-value']);

        if($preset) {
            $old = Group::load(Group::preset());
            $old->preset = 0;
            $old->save();
        }

        $params = "prevname:".$group->name.",name:".$name.",admin:".$admin.",preset:".$preset;
        ActivityFunc::log($current_user->name, "none", "none", "group:edit", $params, 0, date("Y-m-d H:i:s"));

        $group_modified_hook = new GroupModifiedHook($id, $group->name, $name, $group->admin, $admin, $group->preset, $preset, $group->permissions, $permissions);
        $plugin_manager->trigger($group_modified_hook);

        $group->name = $name;
        $group->admin = $admin;
        $group->preset = $preset;
        $group->permissions = $permissions;
        $group->save();
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

$editing = false;
$subPage = "all";
if(isset($_GET['sub'])) {
    $subPage = $_GET['sub'];
}
if(isset($_GET['action']) && isset($_GET['id']) && has_values("groups", " WHERE group_name = '".StringFormatter::clean_input(value("groups", "group_name", " WHERE id = '".StringFormatter::clean_input($_GET['id'])."'"))."'")) {
	$edit_id = StringFormatter::clean_input($_GET['id']);
    $action = StringFormatter::clean_input($_GET['action']);

    if($action == "edit") {
        $editing = true;
    } else if($action == "delete") {
        $params = "id:".$edit_id.",status:".$action;
        ActivityFunc::log(get_name(), $project, $list, "group:delete", $params, 0, date("Y-m-d H:i:s"));
        $group_deleted_hook = new GroupDeletedHook($edit_id);
        $plugin_manager->trigger($group_deleted_hook);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Group '.value("groups", "group_name", " WHERE id = '".$edit_id."'").' has been delete.");';
        echo '</script>';
        Group::delete($edit_id);
    }
}
$rules['form']['templates']['group'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/GroupAddForm.tpl").'}';
$node_values = '';
$nodes = values("nodes", "node_name");
foreach($nodes as &$node) {
    $node_values .= '<div id="node-'.node_id($node).'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$node.'</div>';
}
$rules['form']['content'] = array(
    'nodes' => $node_values,
);
$rules['table'] = array(
    'templates' => array(
        'groups' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'name' => $language_manager->get_value($language, "site->tables->head->name"),
    'admin' => $language_manager->get_value($language, "site->tables->head->admin"),
    'actions' => $language_manager->get_value($language, "site->tables->head->actions"),
);
$rules['table']['pages'] = array(
    'groups' => ' ',
);
$rules['site']['content']['announce'] = $language_manager->get_value($language, "site->tables->missing->groups");
$rules['table']['content'] = array(
    'groups' => ' ',
);

if($editing) {
    $rules['form']['templates']['group'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/GroupEditForm.tpl").'}';
    $group = Group::load(StringFormatter::clean_input($_GET['id']));
    $admin_string = '<option value="0"'.((!$group->is_admin()) ? ' selected' : '').'>No</option>';
    $admin_string .= '<option value="1"'.(($group->is_admin()) ? ' selected' : '').'>Yes</option>';
    $preset_string = '<option value="0"'.(($group->preset == 0) ? ' selected' : '').'>No</option>';
    $preset_string .= '<option value="1"'.(($group->preset == 1) ? ' selected' : '').'>Yes</option>';
    $permissions = '';
    $permissions_used = '';
    $permission_values = implode(",", $group->permissions);
    foreach($nodes as &$node) {
        if(in_array(node_id($node), $group->permissions)) {
            $permissions_used .= '<div id="node-'.node_id($node).'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$node.'</div>';
        } else {
            $permissions .= '<div id="node-'.node_id($node).'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$node.'</div>';
        }
    }
    $rules['form']['value'] = array(
        'id' => $group->id,
        'name' => $group->name,
        'admin' => $admin_string,
        'preset' => $preset_string,
        'permissions' => $permissions,
        'permission_values' => $permission_values,
        'permissions_used' => $permissions_used,
    );
}

global $prefix;
$pagination = new Pagination($prefix."_groups", "id, group_name, group_admin", $pn, 10, "?t=".$type."&amp;");
if(has_values("groups")) {
    $rules['table']['templates']['groups'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Groups.tpl").'}';
    $entries = $pagination->paginate_return();
    $table_content = "";
    foreach ($entries as &$entry) {
        $a = ($entry['group_admin'] == '1') ? "Yes" : "No";
        $table_content .= "<tr>";
        $table_content .= "<td>".$entry['group_name']."</td>";
        $table_content .= "<td>".$a."</td>";
        $table_content .= "<td class='actions'>";
        $table_content .= "<a title='Edit' class='actionEdit' href='?t=groups&amp;action=edit&amp;id=".$entry['id']."&amp;pn=".$pn."'></a>";
        $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete group ".$entry['group_name']."?\");' href='?t=groups&amp;action=delete&amp;id=".$entry['id']."&amp;pn=".$pn."'></a>";
        $table_content .= "</td>";
        $table_content .= "</tr>";
    }
    $rules['table']['pages']['groups'] = $pagination->page_string;
    $rules['table']['content']['groups'] = $table_content;
}