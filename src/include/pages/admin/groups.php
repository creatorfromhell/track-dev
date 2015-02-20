<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 6:53 PM
 * Version: Beta 1
 * Last Modified: 8/7/14 at 6:53 PM
 * Last Modified by Daniel Vidmar.
 */
include_once("include/handling/group.php");
$editing = false;
$subPage = "all";
if(isset($_GET['sub'])) {
    $subPage = $_GET['sub'];
}
if(isset($_GET['action']) && isset($_GET['id']) && has_values("groups", " WHERE group_name = '".clean_input(value("groups", "group_name", " WHERE id = '".clean_input($_GET['id'])."'"))."'")) {
	$editID = clean_input($_GET['id']);
    $action = clean_input($_GET['action']);

    if($action == "edit") {
        $editing = true;
    } else if($action == "delete") {
        $params = "id:".$editID.",status:".$action;
        ActivityFunc::log(get_name(), $project, $list, "group:delete", $params, 0, date("Y-m-d H:i:s"));
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Group '.value("groups", "group_name", " WHERE id = '".$editID."'").' has been delete.");';
        echo '</script>';
        Group::delete($editID);
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
    'name' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->name)),
    'admin' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->admin)),
    'actions' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->actions)),
);
$rules['table']['pages'] = array(
    'groups' => ' ',
);
$rules['site']['content']['announce'] = $formatter->replace_shortcuts(((string)$language_instance->site->tables->nogroups));
$rules['table']['content'] = array(
    'groups' => ' ',
);
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