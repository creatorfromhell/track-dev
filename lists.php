<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/21/14
 * Time: 2:11 PM
 * Version: Beta 1
 * Last Modified: 3/21/14 at 2:11 PM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
include("include/handling/list.php");
include("include/handling/version.php");

$switchable = "lists";
if(isset($_GET['page'])) {
	if($_GET['page'] == 'lists' || $_GET['page'] == 'versions') {
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
        $editID = 0;
        $editing = false;
        if(isset($_GET['action']) && isset($_GET['id'])) {
            $action = cleanInput($_GET['action']);
            $editID = cleanInput($_GET['id']);
			if(isAdmin() || ProjectFunc::getOverseer($project) == getName()) {
				if($switchable == "lists") {
					if($action == "delete") {
						$name = ListFunc::getName($editID);
						ListFunc::remove($editID);
						$params = "id:".$editID;
						ActivityFunc::log(getName(), $project, $name, "list:delete", $params, 0, date("Y-m-d H:i:s"));
						echo '<script type="text/javascript">';
						echo 'showMessage("success", "List '.$name.' has been deleted.");';
						echo '</script>';
					} else if($action == "edit") {
						$editing = true;
					}
				} else if($switchable == "versions") {
					if($action == "delete") {
				
					} else if($action == "edit") {
						$editing = true;
					}
				}
			}
        }
        ?>
		<div class="switchable lists-page" <?php if($switchable != 'lists') { echo 'style="display:none;"'; } ?>>
			<div class="h1-holder">
				<h1><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->lists->header)); ?></h1>
				<div class="switch switch-right"><a href="?page=versions">Versions ></a></div>
			</div>
			<?php if(isAdmin() && $switchable == 'lists' || ProjectFunc::getOverseer($project) == getName() && $switchable == 'lists') { ?>
				<!-- List Form -->
				<form id="list_form" class="trackrForm" method="post" action="lists.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>&page=lists">
					<?php
					if(!$editing) {
						echo ListFunc::printAddForm($project, $projects, getName());
					} else {
						echo ListFunc::printEditForm($editID);
					}
					?>
				</form>
			<?php } ?>

			<!-- Lists -->
			<?php
			if(ProjectFunc::hasLists($project)) {
				global $prefix;
				$pagination = new Pagination($prefix."_lists", "id, list, created, creator, overseer", $pn, 10, "?p=".$project."&page=lists&", "WHERE `project` = '".$project."'");
				echo $pagination->pageString;
			?>
			<table id="lists" class="taskTable">
				<thead>
					<tr>
						<th id="listName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
						<th id="listCreated" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->created)); ?></th>
						<th id="listCreator" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->creator)); ?></th>
						<th id="listOverseer" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->overseer)); ?></th>
						<th id="listAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$entries = $pagination->paginateReturn();
				foreach($entries as &$entry) {
					$id = $entry['id'];
					$name = $entry['list'];
					$created = $entry['created'];
					$creator = $entry['creator'];
					$overseer = $entry['overseer'];

					echo "<tr>";
					echo "<td class='name'><a href='list.php?p=".$project."&amp;l=".$name."'>".$formatter->replace($name)."</a></td>";
					echo "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";
					echo "<td class='creator'>".$formatter->replace($creator)."</td>";
					echo "<td class='overseer'>".$formatter->replace($overseer)."</td><td>";
					if(isAdmin() || ProjectFunc::getOverseer($project) == getName()) {
						echo "<a title='Edit' class='actionEdit' href='?p=".$project."&amp;page=lists&amp;action=edit&amp;id=".$id."'></a>";
						echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete list ".$name."?\");' href='?p=".$project."&action=delete&id=".$id."'></a>";
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
				echo "<p class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->nolists))."</p>";
			}
			?>
		</div>
		<div class="switchable versions-page" <?php if($switchable != 'versions') { echo 'style="display:none;"'; } ?>>
			<div class="h1-holder">
				<div class="switch switch-left"><a href="?page=lists">< Lists</a></div>
				<h1><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->lists->versionsheader)); ?></h1>
			</div>
			
			<?php if(isAdmin() && $switchable == 'versions' || ProjectFunc::getOverseer($project) == getName() && $switchable == 'versions') { ?>
				<!-- Version Form -->
				<form enctype="multipart/form-data" id="version-form" class="trackrForm" method="post" action="lists.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>&page=versions">
					<?php
					if(!$editing) {
						echo VersionFunc::printAddForm($project);
					} else {
						echo VersionFunc::printEditForm($editID);
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
			<?php
			if(VersionFunc::hasVersions($project)) {
				global $prefix;
				$pagination = new Pagination($prefix."_versions", "id, version_name, version_status, version_type", $pn, 10);
				echo $pagination->pageString;
			?>
			<table id="versions" class="taskTable">
				<thead>
					<tr>
						<th id="versionName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
						<th id="versionType" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->type)); ?></th>
						<th id="versionStable" class="small"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->stable)); ?></th>
						<th id="versionAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$entries = $pagination->paginateReturn();
					foreach($entries as &$entry) {
						$id = $entry['id'];
						$name = $entry['version_name'];
						$type = $entry['version_type'];
						$stable = (VersionFunc::stable($entry['version_type'])) ? 'Yes' : 'No';

						echo "<tr>";
						echo "<td class='name'><a href='#'>".$formatter->replace($name)."</a></td>";
						echo "<td class='type'>".$formatter->replace($type)."</td>";
						echo "<td class='stable'>".$formatter->replace($stable)."</td>";
						echo "<td class='actions'>";
						if(isAdmin()) {
							echo "<a title='Edit' class='actionEdit' href='?action=edit&amp;id=".$id."&amp;page=versions'></a>";
							echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete version ".$name."?\");' href='?action=delete&amp;id=".$id."&amp;page=versions'></a>";
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
				echo "<p class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->noversions))."</p>";
			}
			?>
		</div>
    </div>

<?php
include("include/footer.php");
?>