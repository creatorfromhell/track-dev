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
include("include/handling/list.php");
include("include/handling/version.php");

$switchable = "lists";
if(isset($_GET['page'])) {
	if($_GET['page'] == 'lists' || $_GET['page'] == 'versions') {
		$switchable = $_GET['page'];
	}
}
$editID = 0;
$editing = false;
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = cleanInput($_GET['action']);
    $editID = cleanInput($_GET['id']);
    if(isAdmin() || ProjectFunc::getOverseer($project) == getName()) {
        if($switchable == "lists") {
            if($action == "delete") {
                $name = ListFunc::getName($editID);
                ListFunc::remove($editID);
                $params = "id:".$editID;
                ActivityFunc::log(getName(), $project, $name, "list:delete", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "List '.$name.' has been deleted.");';
                echo '</script>';
            } else if($action == "edit") {
                $editing = true;
            }
        } else if($switchable == "versions") {
            if($action == "delete") {

            } else if($action == "edit") {
                $editing = true;
            }
        }
    }
}
$rules['site']['page']['content'] = '{include->'.$manager->GetTemplate((string)$theme->name, "Lists.tpl").'}';
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
        'lists' => '{include->'.$manager->GetTemplate((string)$theme->name, "tables/Lists.tpl").'}',
        'versions'=> '{include->'.$manager->GetTemplate((string)$theme->name, "tables/Versions.tpl").'}',
    ),
);
if($switchable == 'lists') {
    $rules['site']['header']['h1'] = $formatter->replaceShortcuts(((string)$languageinstance->site->pages->lists->header));
    $rules['pages']['lists']['versions']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-right"><a href="?page=versions">Versions ></a></div>';
    if(isAdmin()) {
        $node_values = '';
        $nodes = values("nodes", "node_name");
        foreach($nodes as &$node) {
            $node_values .= '<option value="'.nodeID($node).'">'.$node.'</option>';
        }
        $rules['form']['templates']['list'] = '{include->'.$manager->GetTemplate((string)$theme->name, "forms/ListAddForm.tpl").'}';
        $rules['form']['content'] = array(
            'user' => $currentUser->name,
            'projects' => toOptions($projects, $project),
            'users' => toOptions(values("users", "user_name")),
            'nodes' => $node_values,
        );
        if($editing) {
            $rules['form']['templates']['list'] = '{include->'.$manager->GetTemplate((string)$theme->name, "forms/ListEditForm.tpl").'}';
        }
    }
} else if($switchable == 'versions') {
    $rules['site']['header']['h1'] = $formatter->replaceShortcuts(((string)$languageinstance->site->pages->lists->versionsheader));
    $rules['pages']['lists']['lists']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-left"><a href="?page=lists">< Lists</a></div>';
    if(isAdmin()) {
        $rules['form']['templates']['version'] = '{include->'.$manager->GetTemplate((string)$theme->name, "forms/VersionAddForm.tpl").'}';
        $rules['form']['content'] = array(
            'project' => $project,
            'types' => toOptions(values("version_types", "version_type")),
        );
        if($editing) {
            $rules['form']['templates']['version'] = '{include->'.$manager->GetTemplate((string)$theme->name, "forms/VersionEditForm.tpl").'}';
        }
    }
}
$rules['table']['th'] = array(
    'name' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)),
    'created' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->created)),
    'creator' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->creator)),
    'overseer' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->overseer)),
    'actions' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)),
    'stable' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->stable)),
    'type' => $formatter->replaceShortcuts(((string)$languageinstance->site->tables->type)),
);
$rules['table']['pages'] = array(
    'lists' => ' ',
    'versions' => ' ',
);
$rules['table']['content'] = array(
    'lists' => '<p class="announce">'.$formatter->replaceShortcuts(((string)$languageinstance->site->tables->nolists)).'</p>',
    'versions' => '<p class="announce">'.$formatter->replaceShortcuts(((string)$languageinstance->site->tables->noversions)).'</p>',
);

global $prefix;
$pagination = new Pagination($prefix."_lists", "id, list, created, creator, overseer", $pn, 10, "?p=".$project."&page=lists&", "WHERE `project` = '".$project."'");
if(hasValues("lists", " WHERE project = '".cleanInput($project)."'")) {
    $table_content = "";
    $entries = $pagination->paginateReturn();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $name = $entry['list'];
        $created = $entry['created'];
        $creator = $entry['creator'];
        $overseer = $entry['overseer'];

        $table_content .= "<tr>";
        $table_content .= "<td class='name'><a href='list.php?p=".$project."&amp;l=".$name."'>".$formatter->replace($name)."</a></td>";
        $table_content .= "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";
        $table_content .= "<td class='creator'>".$formatter->replace($creator)."</td>";
        $table_content .= "<td class='overseer'>".$formatter->replace($overseer)."</td><td>";
        if(isAdmin() || ProjectFunc::getOverseer($project) == getName()) {
            $table_content .= "<a title='Edit' class='actionEdit' href='?p=".$project."&amp;page=lists&amp;action=edit&amp;id=".$id."'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete list ".$name."?\");' href='?p=".$project."&amp;action=delete&amp;id=".$id."'></a>";
        } else {
            $table_content .= $formatter->replace("%none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['lists'] = $pagination->pageString;
    $rules['table']['content']['lists'] = $table_content;
}

if(hasValues("versions", " WHERE project = '".cleanInput($project)."'")) {
    $pagination = new Pagination($prefix."_versions", "id, version_name, version_status, version_type", $pn, 10);
    $table_content = "";
    $entries = $pagination->paginateReturn();
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
        if(isAdmin()) {
            $table_content .= "<a title='Edit' class='actionEdit' href='?action=edit&amp;id=".$id."&amp;page=versions'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete version ".$name."?\");' href='?action=delete&amp;id=".$id."&amp;page=versions'></a>";
        } else {
            $table_content .= $formatter->replace("%none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['versions'] = $pagination->pageString;
    $rules['table']['content']['versions'] = $table_content;
}
new SimpleTemplate($manager->GetTemplate((string)$theme->name, "basic/Page.tpl"), $rules, true);
?>