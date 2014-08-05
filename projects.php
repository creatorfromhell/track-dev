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
include("include/handling/projectform.php");
?>

    <div id="main">
        <?php
        $id = 0;
        $editing = false;
        if(isset($_GET['action']) && isset($_GET['id'])) {
            $action = $_GET['action'];
            $id = $_GET['id'];
            if(UserFunc::isAdmin($username) || ProjectFunc::getOverseer(ProjectFunc::getName($id)) == $username) {
                if($action == "delete") {
                    $name = ProjectFunc::getName($id);
                    ProjectFunc::remove($id);
                    $params = "id:".$id;
                    ActivityFunc::log($username, $name, "none", "project:delete", $params, 0, date("Y-m-d H:i:s"));
                    echo '<script type="text/javascript">';
                    echo 'showMessage("success", "Project '.$name.' has been deleted.");';
                    echo '</script>';
                } else if($action == "edit") {
                    $editing = true;
                }
            }
        }
        ?>
        <?php if(UserFunc::isAdmin($username)) { ?>
        <!-- Project Form -->
        <form id="project_form" class="trackrForm" method="post" action="projects.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>">
            <?php
            if(!$editing) {
                echo ProjectFunc::printAddForm($username);
            } else {
                echo ProjectFunc::printEditForm($id);
            }
            ?>
        </form>
        <?php } ?>

        <?php
        if(ProjectFunc::hasProjects()) { ?>
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
                <?php ProjectFunc::printProjects($username, $formatter); ?>
            </tbody>
        </table>
        <?php } else {
            echo "<p  class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->noproject))."</p>";
        } ?>
    </div>

<?php
include("include/footer.php");
?>