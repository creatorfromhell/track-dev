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
        if(isset($_GET['action']) && isset($_GET['id'])) {
            $action = $_GET['action'];
            $id = $_GET['id'];
            if(isAdmin() || ProjectFunc::getOverseer(ProjectFunc::getName($id)) == getName()) {
                if($action == "delete") {
                    $name = ProjectFunc::getName($id);
                    ProjectFunc::remove($id);
                    $params = "id:".$id;
                    ActivityFunc::log(getName(), $name, "none", "project:delete", $params, 0, date("Y-m-d H:i:s"));
                    echo '<script type="text/javascript">';
                    echo 'showMessage("success", "Project '.$name.' has been deleted.");';
                    echo '</script>';
                } else if($action == "edit") {
                    $editing = true;
                }
            }
        }
        ?>
        <?php if(isAdmin()) { ?>
        <!-- Project Form -->
        <form id="project_form" class="trackrForm" method="post" action="projects.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>">
            <?php
            if(!$editing) {
                echo ProjectFunc::printAddForm(getName());
            } else {
                echo ProjectFunc::printEditForm($id);
            }
            ?>
        </form>
        <?php } ?>

        <?php
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
                        echo "<a title='Edit' class='actionEdit' href='?action=edit&id=".$id."'></a>";
                        echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete project ".$name."?\");' href='?action=delete&id=".$id."'></a>";
                    } else {
                        echo $formatter->replace("%none");
                    }
                    echo  "</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php } else {
            echo "<p  class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->noproject))."</p>";
        } ?>
    </div>

<?php
include("include/footer.php");
?>