<?php
/**
 * Created by Daniel Vidmar.
 * Date: 7/17/14
 * Time: 12:30 PM
 * Version: Beta 1
 * Last Modified: 7/17/14 at 12:30 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_GET['action']) && isAdmin() && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if($action == "archive") {

    } else if($action == "delete") {

    }
}
global $prefix;
$pagination = new Pagination($prefix."_activity", "id, archived, logged", $pn, 10);
echo $pagination->pageString;
?>
<table id="activities" class="taskTable">
    <thead>
    <tr>
        <th id="activityDescription" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->activity)); ?></th>
        <th id="activityArchived" class="small"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->archived)); ?></th>
        <th id="activityDate" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->logged)); ?></th>
        <th id="activityAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $entries = $pagination->paginateReturn();
    foreach($entries as &$entry) {
        $id = $entry['id'];
        $description = ActivityFunc::getReadableActivity($id, $formatter->languageinstance);
        $archived = ($entry['archived'] == 1) ? (string)$formatter->languageinstance->site->tables->yes : (string)$formatter->languageinstance->site->tables->no;
        $logged = $entry['logged'];

        echo "<tr>";
        echo "<td class='description'>".$description."</td>";
        echo "<td class='archived'>".$archived."</td>";
        echo "<td class='logged'>".$logged."</td>";
        echo "<td class='actions'>";
        if(isAdmin()) {
            echo "<a title='Edit' class='actionEdit'></a>";
            echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?t=activity&amp;action=delete&amp;id=".$id."'></a>";
        } else {
            echo $formatter->replace("%none");
        }
        echo  "</td></tr>";
    }
    ?>
    </tbody>
</table>