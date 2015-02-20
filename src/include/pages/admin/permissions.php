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
    $action = clean_input($_GET['action']);

    if($action == "edit" && isset($_GET['id']) && has_values("nodes", " WHERE id = '".clean_input($_GET['id'])."'")) {
        $editing = true;
    } else if($action == "delete" && isset($_GET['id']) && has_values("nodes", " WHERE id = '".clean_input($_GET['id'])."'")) {
        node_delete(clean_input($_GET['id']));
    }
}
$rules['form']['templates']['permission'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/NodeAddForm.tpl").'}';
$rules['table'] = array(
    'templates' => array(
        'permissions' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'node' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->node)),
    'description' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->description)),
    'actions' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->actions)),
);
$rules['table']['pages'] = array(
    'permissions' => ' ',
);
$rules['site']['content']['announce'] = $formatter->replace_shortcuts(((string)$language_instance->site->tables->nonodes));
$rules['table']['content'] = array(
    'permissions' => ' ',
);

global $prefix;
$pagination = new Pagination($prefix."_nodes", "id, node_name, node_description", $pn, 10, "?t=".$type."&amp;");
if(has_values('nodes')) {
    $rules['table']['templates']['permissions'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Permissions.tpl").'}';
    $entries = $pagination->paginate_return();
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
    $rules['table']['pages']['permissions'] = $pagination->page_string;
    $rules['table']['content']['permissions'] = $table_content;
}