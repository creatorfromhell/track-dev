<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/25/14
 * Time: 9:44 PM
 * Version: Beta 1
 * Last Modified: 4/25/14 at 9:44 PM
 * Last Modified by Daniel Vidmar.
 */
$id = 0;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: index.php");
}
include("include/header.php");

$back = "list.php?p=".$project."&l=".$list;
$taskDetails = TaskFunc::getDetails($project, $list, $id);

$finished = ($taskDetails['finished'] != "0000-00-00") ? $taskDetails['finished'] : "None";
$due = ($taskDetails['due'] != "0000-00-00") ? $taskDetails['due'] : "None";
$version = ($taskDetails['version'] != "") ? $taskDetails['version'] : "None";
$status = $taskDetails['status'];
$statusName = "Open";
$statusClass = "general";

if($status == "0") { $statusName = "Open"; $statusClass = "general"; }
if($status == "1") { $statusName = "Done"; $statusClass = "success"; }
if($status == "2") { $statusName = "In Progress"; $statusClass = "ip"; }
if($status == "3") { $statusName = "Closed"; $statusClass = "error"; }
?>

    <div id="main">
        <div class="content">
            <!-- title, description, author, assignee, due, created, finished, versionname, labels, editable, taskstatus, progress -->
            <h3><label class="fmleft"><a href="<?php echo $back; ?>" style="text-shadow:none;">Back</a></label><?php echo $taskDetails['title']; ?><label class="fmright"><label class="status <?php echo $statusClass; ?>"><?php echo $statusName; ?></label></label></h3>
            <?php if($status == "2") {
               $progress = $taskDetails['progress']."%";
            ?>

            <div title="<?php echo $progress; ?>" class="progress"><div class="progress-bar" style="width:<?php echo $progress; ?>;"></div></div>
            <?php } ?>
            <div class="task-info">
                <div class="task-column fmleft">
                    <label class="task-author">Author: <a href="#"><?php echo $taskDetails['author']; ?></a></label>
                    <label class="task-created">Created: <?php echo $taskDetails['created']; ?></label>
                    <label class="task-assignee">Assignee: <a href="#"><?php echo $taskDetails['assignee']; ?></a></label>
                </div>
                <div class="task-column fmright">
                    <label class="task-version">Version: <a href="#"><?php echo $version; ?></a></label>
                    <label class="task-due">Due Date: <?php echo $due; ?></label>
                    <label class="task-finish">Completion Date: <?php echo $finished; ?></label>
                </div>
            </div>
            <div class="clear"></div>
            <pre class="task-description"><label class="task-description-title">Description: </label><br /><?php echo $taskDetails['description']; ?></pre>
            <?php if($taskDetails['labels'] != "") { ?>
            <div class="labels"><!--<label id="enhancement" class="task-label">Enhancement</label><label id="feature" class="task-label">Feature</label>--></div>
            <div class="clear"></div>
            <?php } ?>
        </div>
        <!--<div class="below-content">
            <h3>Task Comments</h3>
        </div>-->
    </div>

<?php
include("include/footer.php");
?>