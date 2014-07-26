<?php
/**
 * Created by Daniel Vidmar.
 * Date: 5/13/14
 * Time: 6:19 PM
 * Version: Beta 1
 * Last Modified: 5/13/14 at 6:19 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/handling/groupform.php");
if(isset($_GET['action']) && UserFunc::isAdmin($username) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if($action == "edit") {
        echo GroupFunc::printEditForm($id);
    } else if($action == "delete") {

    }
}
?>
<div id="add" onclick="showDiv('group_add'); return false;"></div>
<form id="group_add" class="trackrForm" method="post">
    <h3>Add Group</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input id="name" name="name" type="text" placeholder="Name">
                <label for="permission">Permission:<label id="permission_value">0</label></label><br />
                <input type="range" id="permission" name="permission" value="0" min="0" max="999" oninput="showValue('permission_value', this.value);">
                <label for="preset">Preset:</label>
                <select name="preset" id="preset">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select><br />
                <label for="admin">Administrator:</label>
                <select name="admin" id="admin">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select><br />
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="hideDiv('group_add'); return false;">Close</button>
                <input type="submit" class="submit" name="add" value="Submit">
            </fieldset>
        </div>
    </div>
</form>
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