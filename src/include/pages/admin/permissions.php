<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 6:53 PM
 * Version: Beta 1
 * Last Modified: 8/7/14 at 6:53 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_POST['add-permission'])) {
    $handler = new NodeAddHandler($_POST);
    try {
        $handler->handle();

        $node = $handler->post_vars['node'];
        $description = $handler->post_vars['description'];

        $node_created_hook = new NodeCreatedHook($node, $description);
        $plugin_manager->trigger($node_created_hook);

        node_add($node, $description);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}

if(isset($_POST['edit-permission'])) {
    $handler = new NodeEditHandler($_POST);
    try {
        $handler->handle();

        $id = $handler->post_vars['id'];
        $details = node_details($id);

        $node = $handler->post_vars['node'];
        $description = $handler->post_vars['description'];

        $node_modified_hook = new NodeModifiedHook($id, $details['node_name'], $node, $details['node_description'], $description);
        $plugin_manager->trigger($node_modified_hook);

        node_edit($id, $node, $description);
    } catch(Exception $e) {
        $translated = $language_manager->get_value($language, $e->getMessage());
        //TODO: form message handling
    }
}
$editing = false;
if(isset($_GET['action']) && isset($_GET['id']) && has_values("nodes", " WHERE id = ?", array($_GET['id']))) {
    $edit_id = StringFormatter::clean_input($_GET['id']);
    $action = StringFormatter::clean_input($_GET['action']);

    if($action == "edit") {
        $editing = true;
    } else if($action == "delete") {
        $node_deleted_hook = new NodeDeletedHook($edit_id);
        $plugin_manager->trigger($node_deleted_hook);
        node_delete($edit_id);
    }
}
$rules['form']['templates']['permission'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/NodeAddForm.tpl").'}';
$rules['table'] = array(
    'templates' => array(
        'permissions' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'node' => $language_manager->get_value($language, "site->tables->head->node"),
    'description' => $language_manager->get_value($language, "site->tables->head->description"),
    'actions' => $language_manager->get_value($language, "site->tables->head->actions"),
);
$rules['table']['pages'] = array(
    'permissions' => ' ',
);
$rules['site']['content']['announce'] = $language_manager->get_value($language, "site->tables->missing->nodes");
$rules['table']['content'] = array(
    'permissions' => ' ',
);

if($editing) {
    $rules['form']['templates']['permission'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/NodeEditForm.tpl").'}';
    $details = node_details(StringFormatter::clean_input($_GET['id']));
    $rules['form']['value'] = array(
        'id' => StringFormatter::clean_input($_GET['id']),
        'name' => $details['node_name'],
        'description' => $details['node_description'],
    );
}

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