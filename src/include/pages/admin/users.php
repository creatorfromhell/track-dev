<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 6:53 PM
 * Version: Beta 1
 * Last Modified: 8/7/14 at 6:53 PM
 * Last Modified by Daniel Vidmar.
 */
include_once("include/handling/user.php");
$editing = false;
$subPage = "all";
if(isset($_GET['sub'])) {
    $subPage = $_GET['sub'];
}
if(isset($_GET['action'])) {
    $action = StringFormatter::clean_input($_GET['action']);

    if($action == "edit" && isset($_GET['id']) && User::exists(value("users", "user_name", " WHERE id = '".StringFormatter::clean_input($_GET['id'])."'"))) {
        $editing = true;
    } else if($action == "delete" && isset($_GET['id']) && User::exists(value("users", "user_name", " WHERE id = '".StringFormatter::clean_input($_GET['id'])."'"))) {
        $params = "id:".$id.",status:".$action;
        ActivityFunc::log(get_name(), $project, $list, "user:delete", $params, 0, date("Y-m-d H:i:s"));
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "User '.value("users", "user_name", " WHERE id = '".StringFormatter::clean_input($_GET['id'])."'").' has been delete.");';
        echo '</script>';
        User::delete(StringFormatter::clean_input($_GET['id']));
    }
}
$rules['form']['templates']['user'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/UserAddForm.tpl").'}';
$group_values = '';
global $prefix, $pdo;
$t = $prefix."_groups";
$stmt = $pdo->prepare("SELECT id, group_name FROM `".$t."`");
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $group_values .= "<option value='".$row['id']."'".(($row['id'] == Group::preset()) ? " selected" : "").">".$row['group_name']."</option>";
}
$node_values = '';
$nodes = values("nodes", "node_name");
foreach($nodes as &$node) {
    $node_values .= '<div id="node-'.node_id($node).'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$node.'</div>';
}
$rules['form']['content'] = array(
    'nodes' => $node_values,
    'groups' => $group_values,
);
$rules['table'] = array(
    'templates' => array(
        'users' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'name' => $language_manager->get_value($language, "site->tables->head->name"),
    'email' => $language_manager->get_value($language, "site->tables->head->email"),
    'group' => $language_manager->get_value($language, "site->tables->head->group"),
    'registered' => $language_manager->get_value($language, "site->tables->head->registered"),
    'actions' => $language_manager->get_value($language, "site->tables->head->actions"),
);
$rules['table']['pages'] = array(
    'users' => ' ',
);
$rules['site']['content']['announce'] = $language_manager->get_value($language, "site->tables->missing->users");
$rules['table']['content'] = array(
    'users' => ' ',
);

if($editing) {
    $user = User::load(StringFormatter::clean_input($_GET['id']), false, true);
    $group_string = '';
    global $prefix, $pdo;
    $t = $prefix."_groups";
    $stmt = $pdo->prepare("SELECT id, group_name FROM `".$t."`");
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $group_string .= "<option value='".$row['id']."'".(($row['id'] == $user->group->id) ? " selected" : "").">".$row['group_name']."</option>";
    }
    $permissions = '';
    $permissions_used = '';
    $permission_values = implode(",", $user->permissions);
    foreach($nodes as &$node) {
        if(in_array(node_id($node), $user->permissions)) {
            $permissions_used .= '<div id="node-'.node_id($node).'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$node.'</div>';
        } else {
            $permissions .= '<div id="node-'.node_id($node).'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$node.'</div>';
        }
    }
    $rules['form']['value'] = array(
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'group' => $group_string,
        'permissions' => $permissions,
        'permission_values' => $permission_values,
        'permissions_used' => $permissions_used,
    );
}

global $prefix;
$pagination = new Pagination($prefix."_users", "id, user_name, user_email, user_group, user_registered", $pn, 10, "?t=".$type."&amp;");
if(has_values("users")) {
    $rules['table']['templates']['users'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Users.tpl").'}';
    $entries = $pagination->paginate_return();
    $table_content = "";
    foreach ($entries as &$entry) {
        $g = Group::load($entry['user_group'])->name;
        $table_content .= "<tr>";
        $table_content .= "<td>".$entry['user_name']."</td>";
        $table_content .= "<td>".$entry['user_email']."</td>";
        $table_content .= "<td>".$g."</td>";
        $table_content .= "<td>".$entry['user_registered']."</td>";
        $table_content .= "<td class='actions'>";
        $table_content .= "<a title='Edit' class='actionEdit' href='?t=users&amp;action=edit&amp;id=".$entry['id']."&amp;pn=".$pn."'></a>";
        $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete user ".$entry['user_name']."?\");' href='?t=users&amp;action=delete&amp;id=".$entry['id']."&amp;pn=".$pn."'></a>";
        $table_content .= "</td>";
        $table_content .= "</tr>";
    }
    $rules['table']['pages']['users'] = $pagination->page_string;
    $rules['table']['content']['users'] = $table_content;
}