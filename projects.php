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
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if(UserFunc::isAdmin($username) || ProjectFunc::getOverseer(ProjectFunc::getName($id)) == $username) {
        if($action == "delete") {
            $name = ProjectFunc::getName($id);
            ProjectFunc::remove($id);
            echo '<script type="text/javascript">';
            echo 'showMessage("success", "Project '.$name.' has been deleted.");';
            echo '</script>';
        }
    }
}
?>

    <div id="main">
        <?php if(UserFunc::isAdmin($username)) { ?>
        <div id="add" onclick="showDiv('project_add'); return false;">

        </div>
        <!-- Add Project -->
        <form id="project_add" class="trackrForm" method="post">
            <h3>Add Project</h3>
            <div id="holder">
                <div id="page_1">
                    <fieldset id="inputs">
                        <input id="name" name="name" type="text" placeholder="Name">
                        <input id="author" name="author" type="hidden" value="<?php echo $username; ?>">
                        <label for="public">Public:</label>
                        <select name="public" id="public">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select><br />
                    </fieldset>
                    <fieldset id="links">
                        <button id="submit_2" onclick="hideDiv('project_add'); return false;">Close</button>
                        <button id="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
                    </fieldset>
                </div>
                <div id="page_2">
                    <fieldset id="inputs">
                        <label for="mainproject">Main:</label>
                        <select name="mainproject" id="mainproject">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select><br />
                        <label for="overseer">Overseer:</label>
                        <select name="overseer" id="overseer">
                            <option value="none" selected>None</option>
                            <?php
                                $users = UserFunc::users();
                                foreach($users as &$user) {
                                    echo '<option value="'.$user.'">'.$user.'</option>';
                                }
                            ?>
                        </select>
                    </fieldset>
                    <fieldset id="links">
                        <button id="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                        <input type="submit" id="submit" name="add" value="Add">
                    </fieldset>
                </div>
            </div>
        </form>
        <?php } ?>

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
            if(ProjectFunc::hasProjects()) {
                ProjectFunc::printProjects($username, $formatter);
            } else {
                echo "<p>".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->noproject))."</p>";
            } ?>
            </tbody>
        </table>
    </div>

<?php
include("include/footer.php");
?>