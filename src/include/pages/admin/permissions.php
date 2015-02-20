<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 6:53 PM
 * Version: Beta 1
 * Last Modified: 8/7/14 at 6:53 PM
 * Last Modified by Daniel Vidmar.
 */
include_once("include/handling/permission.php");
$editing = false;
if(isset($_GET['action'])) {
    $action = cleanInput($_GET['action']);

    if($action == "edit" && isset($_GET['id']) && hasValues("nodes", " WHERE id = '".cleanInput($_GET['id'])."'")) {
        $editing = true;
    } else if($action == "delete" && isset($_GET['id']) && hasValues("nodes", " WHERE id = '".cleanInput($_GET['id'])."'")) {
        nodeDelete(cleanInput($_GET['id']));
    }
}
$rules['form']['templates']['permission'] = '{include->'.$manager->GetTemplate((string)$theme->name, "forms/NodeAddForm.tpl").'}';
$rules['table'] = array(
    'templates' => array(
        'permissions' => '{include->'.$manager->GetTemplate((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'node' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->node)),
    'description' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->description)),
    'actions' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)),
);
$rules['table']['pages'] = array(
    'permissions' => ' ',
);
$rules['site']['content']['announce'] = $formatter->replaceShortcuts(((string)$languageinstance->site->tables->nonodes));
$rules['table']['content'] = array(
    'permissions' => ' ',
);

global $prefix;
$pagination = new Pagination($prefix."_nodes", "id, node_name, node_description", $pn, 10, "?t=".$type."&amp;");
if(hasValues('nodes')) {
    $rules['table']['templates']['permissions'] = '{include->'.$manager->GetTemplate((string)$theme->name, "tables/Permissions.tpl").'}';
    $entries = $pagination->paginateReturn();
    $table_content = "";
    foreach ($entries as &$entry) {
        $table_content .= "<tr>";
        $table_content .= "<td>".$entry['node_name']."</td>";
        $table_content .= "<td>".$entry['node_description']."</td>";
        $table_content .= "<td class='actions'>";
        $table_content .= "<a title='Edit' class='actionEdit' href='?t=permissions&amp;action=edit&amp;id=".$entry['id']."&amp;pn=".$pn."'></a>";
        $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete node ".$entry['node_name']."?\");' href='?t=permissions&amp;action=delete&amp;id=".$entry['id']."&amp;pn=".$pn."'></a>";
        $table_content .= "</td>";
        $table_content .= "</tr>";
    }
    $rules['table']['pages']['permissions'] = $pagination->pageString;
    $rules['table']['content']['permissions'] = $table_content;
}
?>