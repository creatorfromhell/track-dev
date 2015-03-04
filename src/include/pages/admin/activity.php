<?php
/**
 * Created by Daniel Vidmar.
 * Date: 7/17/14
 * Time: 12:30 PM
 * Version: Beta 1
 * Last Modified: 7/17/14 at 12:30 PM
 * Last Modified by Daniel Vidmar.
 */
if(is_admin() && isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $edit_id = $_GET['id'];
    if($action == "archive") {
		ActivityFunc::archive($edit_id);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Activity #'.$edit_id.' has been archived.");';
        echo '</script>';
    } else if($action == "unarchive") {
		ActivityFunc::unarchive($edit_id);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Activity #'.$edit_id.' has been unarchived.");';
        echo '</script>';
    } else if($action == "delete") {
		ActivityFunc::delete($edit_id);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Activity #'.$edit_id.' has been deleted.");';
        echo '</script>';
    }
}
ActivityFunc::clean();
$rules['table'] = array(
    'templates' => array(
        'activities' => '{include->'.$theme_manager->get_template((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'activity' => $language_manager->get_value($language, "site->tables->head->activity"),
    'archived' => $language_manager->get_value($language, "site->tables->head->archived"),
    'logged' => $language_manager->get_value($language, "site->tables->head->logged"),
    'actions' => $language_manager->get_value($language, "site->tables->head->actions"),
);
$rules['table']['pages'] = array(
    'activities' => ' ',
);

$rules['site']['content']['announce'] = $language_manager->get_value($language, "site->tables->missing->activities");
$rules['table']['content'] = array(
    'activities' => ' ',
);
global $prefix;
$pagination = new Pagination($prefix."_activity", "id, archived, logged", $pn, 10, "?t=".$type."&", "ORDER BY logged DESC");

if(has_values("activity")) {
    $rules['table']['templates']['activities'] = '{include->'.$theme_manager->get_template((string)$theme->name, "tables/Activities.tpl").'}';
    $entries = $pagination->paginate_return();
    $table_content = "";
    foreach ($entries as &$entry) {
        $id = $entry['id'];
        $description = ActivityFunc::get_readable_activity($id, $language_manager, $language);
        $archived = ($entry['archived'] == 1) ? $language_manager->get_value($language, "site->actions->general->yes") : $language_manager->get_value($language, "site->actions->general->no");
        $logged = $entry['logged'];

        $table_content .= "<tr>";
        $table_content .= "<td class='description'>" . $description . "</td>";
        $table_content .= "<td class='archived'>" . $archived . "</td>";
        $table_content .= "<td class='logged'>" . $logged . "</td>";
        $table_content .= "<td class='actions'>";
        if (is_admin()) {
            $table_content .= "<a title='Archive' class='actionArchive' href='?t=activity&amp;action=archive&amp;id=" . $id . "&amp;pn=" . $pn . "'></a>";
            $table_content .= "<a title='UnArchive' class='actionUnArchive' href='?t=activity&amp;action=unarchive&amp;id=" . $id . "&amp;pn=" . $pn . "'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?t=activity&amp;action=delete&amp;id=" . $id . "&amp;pn=" . $pn . "'></a>";
        } else {
            $table_content .= $language_manager->get_value($language, "site->actions->general->none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['activities'] = $pagination->page_string;
    $rules['table']['content']['activities'] = $table_content;
}