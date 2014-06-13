<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/13/14
 * Time: 6:20 PM
 * Version: Beta 1
 * Last Modified: 5/13/14 at 6:20 PM
 * Last Modified by Daniel Vidmar.
 */
if(isset($_GET['action']) && UserFunc::isAdmin($username) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if($action == "edit") {

    } else if($action == "delete") {

    }
}
?>
<table id="users" class="taskTable">
    <thead>
        <tr>
            <th id="userName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
            <th id="userEmail" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->email)); ?></th>
            <th id="userGroup" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->group)); ?></th>
            <th id="userRegister" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->registered)); ?></th>
            <th id="userAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
        UserFunc::printUsers($username, $formatter);
    ?>
    </tbody>
</table>