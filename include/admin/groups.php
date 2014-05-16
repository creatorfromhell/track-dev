<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/13/14
 * Time: 6:19 PM
 * Version: Beta 1
 * Last Modified: 5/13/14 at 6:19 PM
 * Last Modified by Daniel Vidmar.
 */
?>
<table id="groups" class="taskTable">
    <thead>
        <tr>
            <th id="groupName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
            <th id="groupPermission" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->permission)); ?></th>
            <th id="groupAdmin" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->admin)); ?></th>
            <th id="groupAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
        GroupFunc::printGroups($username, $formatter);
    ?>
    </tbody>
</table>