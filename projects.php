<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/21/14
 * Time: 10:55 AM
 * Version: Beta 1
 * Last Modified: 3/21/14 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */
include("include/header.php");
include("include/handling/project.php");
include("include/handling/versiontype.php");

$switchable = "projects";
if(isset($_GET['page'])) {
	if($_GET['page'] == 'projects' || $_GET['page'] == 'types') {
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
            $action = $_GET['action'];
            $editID = $_GET['id'];
            if(isAdmin() || ProjectFunc::getOverseer(ProjectFunc::getName($editID)) == getName()) {
				if($switchable == "projects") {
					if($action == "delete") {
						$name = ProjectFunc::getName($editID);
						ProjectFunc::remove($editID);
						$params = "id:".$editID;
						ActivityFunc::log(getName(), $name, "none", "project:delete", $params, 0, date("Y-m-d H:i:s"));
						echo '<script type="text/javascript">';
						echo 'showMessage("success", "Project '.$name.' has been deleted.");';
						echo '</script>';
					} else if($action == "edit") {
						$editing = true;
					}
				} else if($switchable == "types") {
					if($action == "delete") {
					} else if($action == "edit") {
						$editing = true;
					}
				}
            }
        }
        ?>
		<div class="switchable projects-page" <?php if($switchable != 'projects') { echo 'style="display:none;"'; } ?>>
			<div class="h1-holder">
				<h1><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->header)); ?></h1>
				<div class="switch switch-right"><a href="?page=types">Version Types ></a></div>
			</div>
			<?php
			if(isAdmin() && $switchable == 'projects') { ?>
			<!-- Project Form -->
			<form id="project-form" class="trackrForm" method="post" action="projects.php?p=<?php echo $project; ?>&amp;l=<?php echo $list; ?>&amp;page=projects">
				<?php
				if(!$editing) {
					echo ProjectFunc::printAddForm(getName());
				} else {
					echo ProjectFunc::printEditForm($editID);
				}
				?>
			</form>
			<?php
			}
			if(ProjectFunc::hasProjects()) {
				global $prefix;
				$pagination = new Pagination($prefix."_projects", "id, project, creator, created, overseer", $pn, 10);
				echo $pagination->pageString;
			?>
			<!-- Projects -->
			<table id="projects" class="taskTable">
				<thead>
				<tr>
					<th id="projectName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
					<th id="projectCreated" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->created)); ?></th>
					<th id="projectCreator" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->creator)); ?></th>
					<th id="projectOverseer" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->overseer)); ?></th>
					<th id="projectAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php
					$entries = $pagination->paginateReturn();
					foreach($entries as &$entry) {
						$id = $entry['id'];
						$name = $entry['project'];
						$creator = $entry['creator'];
						$created = $entry['created'];
						$overseer = $entry['overseer'];

						echo "<tr>";
						echo "<td class='name'><a href='lists.php?p=".$name."'>".$formatter->replace($name)."</a></td>";
						echo "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";
						echo "<td class='creator'>".$formatter->replace($creator)."</td>";
						echo "<td class='overseer'>".$formatter->replace($overseer)."</td>";
						echo "<td class='actions'>";
						if(isAdmin()) {
							echo "<a title='Edit' class='actionEdit' href='?action=edit&amp;id=".$id."&amp;page=projects'></a>";
							echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete project ".$name."?\");' href='?action=delete&amp;id=".$id."&amp;page=projects'></a>";
						} else {
							echo $formatter->replace("%none");
						}
						echo  "</td></tr>";
					}
					?>
				</tbody>
			</table>
			<?php } else {
				echo "<p  class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->noprojects))."</p>";
			} ?>
		</div>
		<div class="switchable types-page" <?php if($switchable != 'types') { echo 'style="display:none;"'; } ?>>
			<div class="h1-holder">
				<div class="switch switch-left"><a href="?page=projects">< Projects</a></div><h1><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->pages->projects->versiontypeheader)); ?></h1>
			</div>
						<?php
			if(isAdmin() && $switchable == 'types') { ?>
			<!-- Project Form -->
			<form id="version-type-form" class="trackrForm" method="post" action="projects.php?p=<?php echo $project; ?>&amp;l=<?php echo $list; ?>&amp;page=types">
				<?php
				if(!$editing) {
					echo VersionFunc::printTypeAddForm();
				} else {
					echo VersionFunc::printTypeEditForm($editID);
				}
				?>
			</form>
			<?php
			}
			if(VersionFunc::hasTypes()) {
				global $prefix;
				$pagination = new Pagination($prefix."_version_types", "id, version_type, description, version_stability", $pn, 10);
				echo $pagination->pageString;
			?>
			<!-- Projects -->
			<table id="version-types" class="taskTable">
				<thead>
				<tr>
					<th id="typeName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
					<th id="typeDescription" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->description)); ?></th>
					<th id="typeStable" class="small"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->stable)); ?></th>
					<th id="typeAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php
					$entries = $pagination->paginateReturn();
					foreach($entries as &$entry) {
						$id = $entry['id'];
						$name = $entry['version_type'];
						$description = $entry['description'];
						$stable = ($entry['version_stability'] == '0') ? 'No' : 'Yes';

						echo "<tr>";
						echo "<td class='name'><a href='lists.php?p=".$project."'>".$formatter->replace($name)."</a></td>";
						echo "<td class='description'>".$formatter->replace($description)."</td>";
						echo "<td class='stable'>".$formatter->replace($stable)."</td>";
						echo "<td class='actions'>";
						if(isAdmin()) {
							echo "<a title='Edit' class='actionEdit' href='?action=edit&amp;id=".$id."&amp;page=types'></a>";
							echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete version type ".$name."?\");' href='?action=delete&amp;id=".$id."&amp;page=types'></a>";
						} else {
							echo $formatter->replace("%none");
						}
						echo  "</td></tr>";
					}
					?>
				</tbody>
			</table>
			<?php } else {
				echo "<p  class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->notypes))."</p>";
			} ?>
		</div>
    </div>

<?php
include("include/footer.php");
?>