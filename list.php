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
$switchable = "tasks";
if(isset($_GET['page'])) {
	if($_GET['page'] == 'tasks' || $_GET['page'] == 'labels') {
		$switchable = $_GET['page'];
	}
}

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
        if(isset($_GET['action']) && isset($_GET['id']) && canEditTask(ListFunc::getID($project, $list), cleanInput($_GET['id']))) {
            $action = $_GET['action'];
            $editID = $_GET['id'];

			if($switchable == 'tasks') {
				if($action == "open") {
					TaskFunc::changeStatus($project, $list, $editID, 0);
					$params = "id:".$editID.",status:".$action;
					ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
					echo '<script type="text/javascript">';
					echo 'showMessage("success", "The status of task #'.$editID.' has been changed to open.");';
					echo '</script>';
				} else if($action == "done") {
					TaskFunc::changeStatus($project, $list, $editID, 1);
					TaskFunc::changeFinished($project, $list, $editID, date("Y-m-d H:i:s"));
					$params = "id:".$editID.",status:".$action;
					ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
					echo '<script type="text/javascript">';
					echo 'showMessage("success", "The status of task #'.$editID.' has been changed to done.");';
					echo '</script>';
				} else if($action == "inprogress") {
					TaskFunc::changeStatus($project, $list, $editID, 2);
					$params = "id:".$editID.",status:".$action;
					ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
					echo '<script type="text/javascript">';
					echo 'showMessage("success", "The status of task #'.$editID.' has been changed to in progress.");';
					echo '</script>';
				} else if($action == "close") {
					TaskFunc::changeStatus($project, $list, $editID, 3);
					$params = "id:".$editID.",status:".$action;
					ActivityFunc::log(getName(), $project, $list, "task:status", $params, 0, date("Y-m-d H:i:s"));
					echo '<script type="text/javascript">';
					echo 'showMessage("success", "The status of task #'.$editID.' has been changed to closed.");';
					echo '</script>';
				} else if($action == "delete") {
					TaskFunc::delete($project, $list, $editID);
					$params = "id:".$editID;
					ActivityFunc::log(getName(), $project, $list, "task:delete", $params, 0, date("Y-m-d H:i:s"));
					echo '<script type="text/javascript">';
					echo 'showMessage("success", "Task #'.$editID.' has been deleted.");';
					echo '</script>';
				} else if($action == "edit") {
					$editing = true;
				}
			} else if($switchable == 'labels') {
				if($action == "edit") {
					$editing = true;
				} else if($action == "delete") {
					LabelFunc::delete($editID);
					$params = "id:".$editID;
					ActivityFunc::log(getName(), $project, $list, "label:delete", $params, 0, date("Y-m-d H:i:s"));
					echo '<script type="text/javascript">';
					echo 'showMessage("success", "Label #'.$editID.' has been deleted.");';
					echo '</script>';
				}
			}
        }
        ?>
		<div class="switchable tasks-page" <?php if($switchable != 'tasks') { echo 'style="display:none;"'; } ?>>
			<div class="h1-holder">
				<h1><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->header)); ?></h1>
				<div class="switch switch-right"><a href="?page=labels">Labels ></a></div>
			</div>
        <?php if(canEditList(ListFunc::getID($project, $list)) && $switchable == 'tasks') { ?>
            <!-- Task Form -->
            <form id="task-form" class="trackrForm" method="post" action="list.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>&page=<?php echo $switchable; ?>">
                <?php
                    if(!$editing) {
                        echo TaskFunc::printAddForm($project, $list, getName());
                    } else {
                        echo TaskFunc::printEditForm($project, $list, $editID);
                    }
                ?>
            </form>
			<script>
			new datepickr('due-date', {
				fullCurrentMonth: true,
				dateFormat: 'Y-m-d',
				weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
				months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				suffix: { 1: 'st', 2: 'nd', 3: 'rd' },
				defaultSuffix: 'th'
			});
			</script>
        <?php } ?>

        <!-- Tasks -->
        <?php
        if(!ListFunc::isEmpty(ListFunc::getID($project, $list)) && canViewList(ListFunc::getID($project, $list))) {
            global $prefix;
            $pagination = new Pagination($prefix."_".$project."_".$list, "id, title, author, assignee, created, editable, task_status", $pn, 10, "?p=".$project."&l=".$list."&page=tasks&", "ORDER BY task_status, id");
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
                    $basic = "p=".$project."&amp;l=".$list."&amp;page=tasks";
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
            echo '<p class="announce">'.$formatter->replaceShortcuts(((string)$languageinstance->site->tables->notasks)).'</p>';
        } ?>
		</div>
		<div class="switchable labels-page" <?php if($switchable != 'labels') { echo 'style="display:none;"'; } ?>>
			<div class="h1-holder">
				<div class="switch switch-left"><a href="?page=tasks">< Tasks</a></div><h1><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->tasks->labelsheader)); ?></h1>
			</div>
			<?php if(canEditList(ListFunc::getID($project, $list)) && $switchable == 'labels') { ?>
			<form id="label-form" class="trackrForm" method="post" action="list.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>&page=<?php echo $switchable; ?>">
				<div id="holder">
					<?php
					if(!$editing) {
						echo LabelFunc::printAddForm($project, $list);
					} else {
						echo LabelFunc::printEditForm($editID);
					}
					?>
				</div>
			</form>
            <?php } 
			if(LabelFunc::hasLabels($project, $list)) {
				global $prefix;
				$pagination = new Pagination($prefix."_labels", "id, label_name, text_color, background_color", $pn, 10, "?p=".$project."&l=".$list."&page=labels&", "WHERE project = '".$project."' AND list = '".$list."' ORDER BY id");
				echo $pagination->pageString;
			?>
			<table id="label" class="taskTable">
				<thead>
					<tr>
						<th id="labelID" class="small">#</th>
						<th id="labelName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
						<th id="taskAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$entries = $pagination->paginateReturn();
				foreach($entries as &$entry) {
					$id = $entry['id'];
					$name = $entry['label_name'];
					$color = $entry['text_color'];
					$background = $entry['background_color'];

					echo "<tr style='color:".$color.";background:".$background.";'>";
					echo "<td class='id'>".$id."</td>";
					echo "<td class='label'>".$formatter->replace($name)."</td>";
					echo "<td class='actions'>";
					if(canEditList(ListFunc::getID($project, $list))) {
						$basic = "p=".$project."&amp;l=".$list."&amp;page=labels";

						echo "<a title='Edit' class='actionEdit' href='?".$basic."&amp;action=edit&amp;id=".$id."'></a>";
						echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete label #".$id."?\");' href='?".$basic."&amp;action=delete&amp;id=".$id."'></a>";
					} else {
						echo $formatter->replace("%none");
					}
					echo  "</td></tr>";
				}
				?>
				</tbody>
			</table>
			<?php
			} else {
				echo "<p class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->nolabels))."</p>";
			}
			?>
			<div id="jspalette"></div>
		</div>
    </div>

<?php
include("include/footer.php");
?>