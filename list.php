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

$configs = ListFunc::configurations(ListFunc::getID($project, $list));
$minimal = ListFunc::minimal(ListFunc::getID($project, $list));
include("include/handling/task.php");
include("include/handling/label.php");
$pn = 1;
if(isset($_GET['pn'])) {
    if($_GET['pn'] > 0) {
        $pn = $_GET['pn'];
    }
}
?>

    <div id="main">
        <?php
        $id = 0;
        $editing = false;
        $editingLabel = false;
        if(isset($_GET['action']) && isset($_GET['id']) && canEditTask(ListFunc::getID($project, $list), cleanInput($_GET['id']))) {
            $action = $_GET['action'];
            $id = $_GET['id'];

            if($action == "open") {
                TaskFunc::changeStatus($project, $list, $id, 0);
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to open.");';
                echo '</script>';
            } else if($action == "done") {
                TaskFunc::changeStatus($project, $list, $id, 1);
                TaskFunc::changeFinished($project, $list, $id, date("Y-m-d H:i:s"));
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to done.");';
                echo '</script>';
            } else if($action == "inprogress") {
                TaskFunc::changeStatus($project, $list, $id, 2);
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to in progress.");';
                echo '</script>';
            } else if($action == "close") {
                TaskFunc::changeStatus($project, $list, $id, 3);
                $params = "id:".$id.",status:".$action;
                ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "The status of task #'.$id.' has been changed to closed.");';
                echo '</script>';
            } else if($action == "delete") {
                TaskFunc::delete($project, $list, $id);
                $params = "id:".$id;
                ActivityFunc::log(getName(), $project, $list, "task:delete", $params, 0, date("Y-m-d H:i:s"));
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
                ActivityFunc::log(getName(), $project, $list, "label:delete", $params, 0, date("Y-m-d H:i:s"));
                echo '<script type="text/javascript">';
                echo 'showMessage("success", "Label #'.$id.' has been deleted.");';
                echo '</script>';
            }
        }
        ?>
        <?php if(canEditList(ListFunc::getID($project, $list))) { ?>
            <!-- Task Form -->
            <form id="task_form" class="trackrForm" method="post" action="list.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>">
                <?php
                    if(!$editing) {
                        echo TaskFunc::printAddForm($project, $list, getName());
                    } else {
                        echo TaskFunc::printEditForm($project, $list, $id);
                    }
                ?>
            </form>
        <?php } ?>

        <!-- Tasks -->
        <?php
        if(!ListFunc::isEmpty(ListFunc::getID($project, $list)) && canViewList(ListFunc::getID($project, $list))) {
            global $prefix;
            $pagination = new Pagination($prefix."_".$project."_".$list, "id, title, author, assignee, created, editable, task_status", $pn, 10, "ORDER BY task_status, id");
            echo $pagination->pageString;
        ?>
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
            <?php
            $entries = $pagination->paginateReturn();
            foreach($entries as &$entry) {
                $id = $entry['id'];
                $title = $entry['title'];
                $author = $entry['author'];
                $assignee = $entry['assignee'];
                $created = $entry['created'];
                $editable = $entry['editable'];
                $status = $entry['task_status'];

                if($status == "1") { echo "<tr class='done'>"; }
                else if($status == "2") { echo "<tr class='inprogress'>"; }
                else if($status == "3") { echo "<tr class='closed'>"; }
                else { echo "<tr>"; }

                echo "<td class='id'>".$id."</td>";
                $link = "task.php?p=".$project."&amp;l=".$list."&amp;id=".$id;
                echo "<td class='title'><a href='".$link."'>".$formatter->replace($title)."</a></td>";
                if(!$minimal) {
                    //assignee
                    echo "<td class='assignee'>".$formatter->replace($assignee)."</td>";

                    //created
                    echo "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";

                    //author
                    echo "<td class='author'>".$formatter->replace($author)."</td>";
                }
                echo "<td class='actions'>";
                if(canEditTask(ListFunc::getID($project, $list), $id)) {
                    $basic = "p=".$project."&amp;l=".$list;
                    $open = "<a title='Open' class='actionOpen' href='?".$basic."&amp;action=open&amp;id=".$id."'></a>";
                    $done = "<a title='Done' class='actionDone' href='?".$basic."&amp;action=done&amp;id=".$id."'></a>";
                    $inprogress = "<a title='In Progress' class='actionProgress' href='?".$basic."&amp;action=inprogress&amp;id=".$id."'></a>";
                    $close = "<a title='Close' class='actionClose' href='?".$basic."&amp;action=close&amp;id=".$id."'></a>";

                    if($status != "0") { echo $open; }
                    if($status != "1") { echo $done; }
                    if($status != "2") { echo $inprogress; }
                    if($status != "3") { echo $close; }

                    echo "<a title='Edit' class='actionEdit' href='?".$basic."&amp;action=edit&amp;id=".$id."'></a>";
                    echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete task #".$id."?\");' href='?".$basic."&amp;action=delete&amp;id=".$id."'></a>";
                } else {
                    echo $formatter->replace("%none");
                }
                echo  "</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <?php } else {
            echo '<p class="announce">'.$formatter->replaceShortcuts(((string)$languageinstance->site->tables->notask)).'</p>';
        } ?>
        <div class="below-content">
            <h3>Labels</h3>
            <div class="labels-left" style="max-height:204px;min-height:204px;">
            <?php
                $labels = LabelFunc::labels($project, $list);
                foreach($labels as &$label) {
                    echo '<div id="'.$label['id'].'" class="list-label" style="background:'.$label['background'].';border:1px solid '.$label['text'].';">';
                    echo '<label style="color:'.$label['text'].';">'.$label['label'].'</label>';
                    if(isAdmin()) {
                        echo '<div class="label-actions"><a class="label-edit-action"></a><a class="label-delete-action"></a></div>';
                    }
                    echo '</div>';
                }
            ?>
            </div>
            <div class="labels-right" style="max-height:270px;min-height:204px;">
                <?php if(canEditList(ListFunc::getID($project, $list))) { ?>
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