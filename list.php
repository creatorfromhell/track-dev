<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/17/14
 * Time: 1:03 PM
 * Version: Beta 1
 * Last Modified: 3/17/14 at 1:03 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");

$configs = ListFunc::configurations($project, $list);
$minimal = ListFunc::minimal($list, $project);
$canEdit = UserFunc::canEdit($project, $list, $username);
$canView = UserFunc::canView($project, $list, $username);
if(isset($_GET['action']) && isset($_GET['id']) && $canEdit) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if($action == "open") {
        TaskFunc::changeStatus($project, $list, $id, 0);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "The status of task #'.$id.' has been changed to open.");';
        echo '</script>';
    } else if($action == "done") {
        TaskFunc::changeStatus($project, $list, $id, 1);
        TaskFunc::changeFinished($project, $list, $id, date("Y-m-d H:i:s"));
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "The status of task #'.$id.' has been changed to done.");';
        echo '</script>';
    } else if($action == "inprogress") {
        TaskFunc::changeStatus($project, $list, $id, 2);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "The status of task #'.$id.' has been changed to in progress.");';
        echo '</script>';
    } else if($action == "close") {
        TaskFunc::changeStatus($project, $list, $id, 3);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "The status of task #'.$id.' has been changed to closed.");';
        echo '</script>';
    } else if($action == "delete") {
        TaskFunc::delete($project, $list, $id);
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "Task #'.$id.' has been deleted.");';
        echo '</script>';
    }
}
include("include/handling/taskform.php");
?>

    <div id="main">
        <?php if($canEdit) { ?>
        <div id="add" onclick="showDiv('task_add'); return false;">

        </div>
        <!-- Add Task Form -->
        <form id="task_add" class="trackrForm" method="post">
            <h3>Add Task</h3>
              <div id="holder">
                <div id="page_1">
                    <fieldset id="inputs">
                        <input id="title" name="title" type="text" placeholder="Title">
                        <textarea id="description" name="description" ROWS="3" COLS="40"></textarea>
                        <input id="author" name="author" type="hidden" value="<?php echo $username; ?>">
                        <label for="assignee">Assignee:</label>
                        <select name="assignee" id="assignee">
                            <option value="none" selected>None</option>
                            <?php
                            $users = UserFunc::users();
                            foreach($users as &$user) {
                                echo '<option value="'.$user.'">'.$user.'</option>';
                            }
                            ?>
                        </select>
                        <?php //TODO: Add due date field ?>
                    </fieldset>
                    <fieldset id="links">
                        <button id="submit_2" onclick="hideDiv('task_add'); return false;">Close</button>
                        <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
                    </fieldset>
                </div>
                <div id="page_2">
                    <fieldset id="inputs">
                        <label for="editable">Editable:</label>
                        <select name="editable" id="editable">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select><br />
                        <label for="status">Status:</label>
                        <select name="status" id="status">
                            <option value="0" selected>None</option>
                            <option value="1">Done</option>
                            <option value="2">In Progress</option>
                            <option value="3">Closed</option>
                        </select><br />
                        <label for="progress">Progress:<label id="progress_value">0</label></label><br />
                        <input type="range" id="progress" name="progress" value="0" min="0" max="100" oninput="showValue('progress_value', this.value);">
                        <!--<label for="version">Version:</label>
                        <select name="version" id="version">
                            <?php //TODO: print out versions for this project. ?>
                        </select><br />-->
                        <?php //TODO: Add labels field. ?>
                    </fieldset>
                    <fieldset id="links">
                        <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                        <input type="submit" id="submit" name="add" value="Add">
                    </fieldset>
                </div>
            </div>
        </form>
        <?php } ?>

        <!-- Tasks -->
        <?php if(!ListFunc::isEmpty($project, $list) && $canView) { ?>
        <table id="list" class="taskTable">
            <thead>
                <tr>
                    <th id="taskID" class="small">#</th>
                    <th id="taskTitle" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
                    <?php
                        if(!$minimal) {
                    ?>
                        <th id="taskAssignee" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->assignee)); ?></th>
                        <th id="taskCreated" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->created)); ?></th>
                        <th id="taskAuthor" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->author)); ?></th>
                    <?php } ?>
                    <th id="taskAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php ListFunc::printTasks($project, $list, $formatter, $minimal, $canEdit, $username); ?>
            </tbody>
        </table>
        <?php } else {
            echo "<p>".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->notask))."</p>";
        } ?>
    </div>

<?php
include("include/footer.php");
?>