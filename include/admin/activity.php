<?php
/**
 * Created by Daniel Vidmar.
 * Date: 7/17/14
 * Time: 12:30 PM
 * Version: Beta 1
 * Last Modified: 7/17/14 at 12:30 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_GET['action']) && UserFunc::isAdmin($username) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if($action == "archive") {

    } else if($action == "delete") {

    }
}
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
        ActivityFunc::printActivities($username, $formatter);
    ?>
    </tbody>
</table>