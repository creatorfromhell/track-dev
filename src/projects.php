<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/21/14
 * Time: 10:55 AM
 * Version: Beta 1
 * Last Modified: 3/21/14 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
include("include/handling/project.php");
include("include/handling/versiontype.php");

$switchable = "projects";
if(isset($_GET['page'])) {
	if($_GET['page'] == 'projects' || $_GET['page'] == 'types') {
		$switchable = $_GET['page'];
	}
}
$editID = 0;
$editing = false;
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $editID = $_GET['id'];
    if(is_admin() || ProjectFunc::get_overseer(ProjectFunc::get_name($editID)) == get_name()) {
        if($switchable == "projects") {
            if($action == "delete") {
                $name = ProjectFunc::get_name($editID);
                ProjectFunc::remove($editID);
                $params = "id:".$editID;
                ActivityFunc::log(get_name(), $name, "none", "project:delete", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "Project '.$name.' has been deleted.");';
                echo '</script>';
            } else if($action == "edit") {
                $editing = true;
            }
        } else if($switchable == "types") {
            if($action == "delete") {
            } else if($action == "edit") {
                $editing = true;
            }
        }
    }
}
$rules['site']['page']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "Projects.tpl").'}';
$rules['pages']['projects']['projects']['style'] = ' ';
$rules['pages']['projects']['types']['style'] = ' ';
$rules['form'] = array(
    'templates' => array(
        'project' => ' ',
        'type'=> ' ',
    ),
);
$rules['table'] = array(
    'templates' => array(
        'projects' => '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Projects.tpl").'}',
        'types'=> '{include->'.$theme_manager->get_template((string)$theme->name, "tables/VersionTypes.tpl").'}',
    ),
);
if($switchable == 'projects') {
    $rules['site']['header']['h1'] = $formatter->replace_shortcuts(((string)$language_instance->site->header));
    $rules['pages']['projects']['types']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-right"><a href="?page=types">Version Types ></a></div>';
    if(is_admin()) {
        $rules['form']['templates']['project'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/ProjectAddForm.tpl").'}';
        $rules['form']['content'] = array(
            'user' => $current_user->name,
            'users' => to_options(values("users", "user_name")),
        );
        if($editing) {
            $rules['form']['templates']['project'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/ProjectEditForm.tpl").'}';
        }
    }
} else if($switchable == 'types') {
    $rules['site']['header']['h1'] = $formatter->replace_shortcuts(((string)$language_instance->site->pages->projects->versiontypeheader));
    $rules['pages']['projects']['projects']['style'] = 'style="display:none;"';
    $rules['pages']['switch'] = '<div class="switch switch-left"><a href="?page=projects">< Projects</a></div>';
    if(is_admin()) {
        $rules['form']['templates']['type'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/TypeAddForm.tpl").'}';
        if($editing) {
            $rules['form']['templates']['type'] = '{include->'.$theme_manager->get_template((string)$theme->name, "forms/TypeEditForm.tpl").'}';
        }
    }
}
$rules['table']['th'] = array(
    'name' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->name)),
    'created' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->created)),
    'creator' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->creator)),
    'overseer' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->overseer)),
    'actions' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->actions)),
    'stable' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->stable)),
    'description' => $formatter->replace_shortcuts(((string)$language_instance->site->tables->description)),
);
$rules['table']['pages'] = array(
    'projects' => ' ',
    'types' => ' ',
);
$rules['table']['content'] = array(
    'projects' => '<p class="announce">'.$formatter->replace_shortcuts(((string)$language_instance->site->tables->noprojects)).'</p>',
    'types' => '<p class="announce">'.$formatter->replace_shortcuts(((string)$language_instance->site->tables->notypes)).'</p>',
);

global $prefix;
$pagination = new Pagination($prefix."_projects", "id, project, creator, created, overseer", $pn, 10);
if(has_values("projects")) {
    $table_content = "";
    $entries = $pagination->paginate_return();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $name = $entry['project'];
        $creator = $entry['creator'];
        $created = $entry['created'];
        $overseer = $entry['overseer'];

        $table_content .= "<tr>";
        $table_content .= "<td class='name'><a href='lists.php?p=".$name."'>".$formatter->replace($name)."</a></td>";
        $table_content .= "<td class='created'>".$formatter->replace($formatter->format_date($created))."</td>";
        $table_content .= "<td class='creator'>".$formatter->replace($creator)."</td>";
        $table_content .= "<td class='overseer'>".$formatter->replace($overseer)."</td>";
        $table_content .= "<td class='actions'>";
        if(is_admin()) {
            $table_content .= "<a title='Edit' class='actionEdit' href='?action=edit&amp;id=".$id."&amp;page=projects'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete project ".$name."?\");' href='?action=delete&amp;id=".$id."&amp;page=projects'></a>";
        } else {
            $table_content .= $formatter->replace("%none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['projects'] = $pagination->page_string;
    $rules['table']['content']['projects'] = $table_content;
}

if(has_values("version_types")) {
    $pagination = new Pagination($prefix."_version_types", "id, version_type, description, version_stability", $pn, 10);
    $table_content = "";
    $entries = $pagination->paginate_return();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $name = $entry['version_type'];
        $description = $entry['description'];
        $stable = ($entry['version_stability'] == '0') ? 'No' : 'Yes';

        $table_content .= "<tr>";
        $table_content .= "<td class='name'><a href='lists.php?p=".$project."'>".$formatter->replace($name)."</a></td>";
        $table_content .= "<td class='description'>".$formatter->replace($description)."</td>";
        $table_content .= "<td class='stable'>".$formatter->replace($stable)."</td>";
        $table_content .= "<td class='actions'>";
        if(is_admin()) {
            $table_content .= "<a title='Edit' class='actionEdit' href='?action=edit&amp;id=".$id."&amp;page=types'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete version type ".$name."?\");' href='?action=delete&amp;id=".$id."&amp;page=types'></a>";
        } else {
            $table_content .= $formatter->replace("%none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['types'] = $pagination->page_string;
    $rules['table']['content']['types'] = $table_content;
}
new SimpleTemplate($theme_manager->get_template((string)$theme->name, "basic/Page.tpl"), $rules, true);