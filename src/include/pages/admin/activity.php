<?php
/**
 * Created by Daniel Vidmar.
 * Date: 7/17/14
 * Time: 12:30 PM
 * Version: Beta 1
 * Last Modified: 7/17/14 at 12:30 PM
 * Last Modified by Daniel Vidmar.
 */
if(isAdmin() && isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $editID = $_GET['id'];
    if($action == "archive") {
		ActivityFunc::archive($editID);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Activity #'.$editID.' has been archived.");';
        echo '</script>';
    } else if($action == "unarchive") {
		ActivityFunc::unarchive($editID);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Activity #'.$editID.' has been unarchived.");';
        echo '</script>';
    } else if($action == "delete") {
		ActivityFunc::delete($editID);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Activity #'.$editID.' has been deleted.");';
        echo '</script>';
    }
}
ActivityFunc::clean();
$rules['table'] = array(
    'templates' => array(
        'activities' => '{include->'.$theme_manager->GetTemplate((string)$theme->name, "basic/AnnounceContent.tpl").'}',
    ),
);
$rules['table']['th'] = array(
    'activity' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->activity)),
    'archived' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->archived)),
    'logged' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->logged)),
    'actions' => $formatter->replaceShortcuts(((string)$language_instance->site->tables->actions)),
);
$rules['table']['pages'] = array(
    'activities' => ' ',
);

$rules['site']['content']['announce'] = $formatter->replaceShortcuts(((string)$language_instance->site->tables->noactivities));
$rules['table']['content'] = array(
    'activities' => ' ',
);
global $prefix;
$pagination = new Pagination($prefix."_activity", "id, archived, logged", $pn, 10, "?t=".$type."&", "ORDER BY logged DESC");

if(hasValues("activity")) {
    $rules['table']['templates']['activities'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "tables/activities.tpl").'}';
    $entries = $pagination->paginateReturn();
    $table_content = "";
    foreach ($entries as &$entry) {
        $id = $entry['id'];
        $description = ActivityFunc::getReadableActivity($id, $formatter->languageinstance);
        $archived = ($entry['archived'] == 1) ? (string)$formatter->languageinstance->site->tables->yes : (string)$formatter->languageinstance->site->tables->no;
        $logged = $entry['logged'];

        $table_content .= "<tr>";
        $table_content .= "<td class='description'>" . $description . "</td>";
        $table_content .= "<td class='archived'>" . $archived . "</td>";
        $table_content .= "<td class='logged'>" . $logged . "</td>";
        $table_content .= "<td class='actions'>";
        if (isAdmin()) {
            $table_content .= "<a title='Archive' class='actionArchive' href='?t=activity&amp;action=archive&amp;id=" . $id . "&amp;pn=" . $pn . "'></a>";
            $table_content .= "<a title='UnArchive' class='actionUnArchive' href='?t=activity&amp;action=unarchive&amp;id=" . $id . "&amp;pn=" . $pn . "'></a>";
            $table_content .= "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?t=activity&amp;action=delete&amp;id=" . $id . "&amp;pn=" . $pn . "'></a>";
        } else {
            $table_content .= $formatter->replace("%none");
        }
        $table_content .= "</td></tr>";
    }
    $rules['table']['pages']['activities'] = $pagination->pageString;
    $rules['table']['content']['activities'] = $table_content;
}