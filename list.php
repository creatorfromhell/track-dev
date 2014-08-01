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
include("include/handling/taskform.php");
include("include/handling/labelform.php");
?>

    <div id="main">
        <?php
        $id = 0;
        $editing = false;
        $editingLabel = false;
        if(isset($_GET['action']) && isset($_GET['id']) && $canEdit) {
            $action = $_GET['action'];
            $id = $_GET['id'];

            if($action == "open") {
                TaskFunc::changeStatus($project, $list, $id, 0);
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log($username, $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to open.");';
                echo '</script>';
            } else if($action == "done") {
                TaskFunc::changeStatus($project, $list, $id, 1);
                TaskFunc::changeFinished($project, $list, $id, date("Y-m-d H:i:s"));
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log($username, $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to done.");';
                echo '</script>';
            } else if($action == "inprogress") {
                TaskFunc::changeStatus($project, $list, $id, 2);
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log($username, $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to in progress.");';
                echo '</script>';
            } else if($action == "close") {
                TaskFunc::changeStatus($project, $list, $id, 3);
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log($username, $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to closed.");';
                echo '</script>';
            } else if($action == "delete") {
                TaskFunc::delete($project, $list, $id);
                $params = "id:".$id;
                ActivityFunc::log($username, $project, $list, "task:delete", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "Task #'.$id.' has been deleted.");';
                echo '</script>';
            } else if($action == "edit") {
                $editing = true;
            } else if($action == "editl") {
                $editingLabel = true;
            } else if($action == "deletel") {
                LabelFunc::delete($id);
                $params = "id:".$id;
                ActivityFunc::log($username, $project, $list, "label:delete", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "Label #'.$id.' has been deleted.");';
                echo '</script>';
            }
        }
        ?>
        <?php if($canEdit) { ?>
            <!-- Task Form -->
            <form id="task_form" class="trackrForm" method="post" action="list.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>">
                <?php
                    if(!$editing) {
                        echo TaskFunc::printAddForm($project, $list, $username);
                    } else {
                        echo TaskFunc::printEditForm($project, $list, $id);
                    }
                ?>
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
            echo "<p class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->notask))."</p>";
        } ?>
        <div class="below-content">
            <h3>Labels</h3>
            <div class="labels-left" style="max-height:204px;min-height:204px;">
            <?php
                $labels = LabelFunc::labels($project, $list);
                foreach($labels as &$label) {
                    echo '<div id="'.$label['id'].'" class="list-label" style="background:'.$label['background'].';border:1px solid '.$label['text'].';">';
                    echo '<label style="color:'.$label['text'].';">'.$label['label'].'</label>';
                    if(UserFunc::isAdmin($username)) {
                        echo '<div class="label-actions"><a class="label-edit-action"></a><a class="label-delete-action"></a></div>';
                    }
                    echo '</div>';
                }
            ?>
            </div>
            <div class="labels-right" style="max-height:270px;min-height:204px;">
                <?php if($canEdit) { ?>
                    <!-- Label Form -->
                    <form id="label_form" class="trackr-small-form" method="post" action="list.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>">
                        <div id="holder">
                        <?php
                        if(!$editingLabel) {
                            echo LabelFunc::printAddForm($project, $list);
                        } else {
                            echo LabelFunc::printEditForm($id);
                        }
                        ?>
                        </div>
                    </form>
                    <div id="jspalette"></div>
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>

<?php
include("include/footer.php");
?>