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
    $action = cleanInput($_GET['action']);

    if($action == "edit" && isset($_GET['id']) && User::exists(value("users", "user_name", " WHERE id = '".cleanInput($_GET['id'])."'"))) {
        $editing = true;
    } else if($action == "delete" && isset($_GET['id']) && User::exists(value("users", "user_name", " WHERE id = '".cleanInput($_GET['id'])."'"))) {
        $params = "id:".$id.",status:".$action;
        ActivityFunc::log(getName(), $project, $list, "user:delete", $params, 0, date("Y-m-d H:i:s"));
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "User '.value("users", "user_name", " WHERE id = '".cleanInput($_GET['id'])."'").' has been delete.");';
        echo '</script>';
        User::delete(cleanInput($_GET['id']));
    }
}
$rules['form']['templates']['user'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "forms/UserAddForm.tpl").'}';
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
    $node_values .= '<div id="node-'.nodeID($node).'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$node.'</div>';
}
$rules['form']['content'] = array(
    'nodes' => $node_values,
    'groups' => $group_values,
);
$rules['table'] = array(
    'templates' => array(
        'users' => '{include->'.$theme_manager->GetTemplate((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'name' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->name)),
    'email' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->email)),
    'group' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->group)),
    'registered' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->registered)),
    'actions' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->actions)),
);
$rules['table']['pages'] = array(
    'users' => ' ',
);
$rules['site']['content']['announce'] = $formatter->replaceShortcuts(((string)$language_instance->site->tables->nogroups));
$rules['table']['content'] = array(
    'users' => ' ',
);
global $prefix;
$pagination = new Pagination($prefix."_users", "id, user_name, user_email, user_group, user_registered", $pn, 10, "?t=".$type."&amp;");
if(hasValues("users")) {
    $rules['table']['templates']['users'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "tables/Users.tpl").'}';
    $entries = $pagination->paginateReturn();
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
    $rules['table']['pages']['users'] = $pagination->pageString;
    $rules['table']['content']['users'] = $table_content;
}