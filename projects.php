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
        <!-- Add Project -->
        <?php if(UserFunc::isAdmin($username)) { ?>
        <form id="project_add" method="post">
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
                        <button id="submit_2" onclick="closeDiv(event, 'list_add'); return false;">Close</button>
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
        <table id="projects">
            <thead>
            <tr>
                <th class="projectName"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->project)); ?></th>
                <th class="projectCreated"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->created)); ?></th>
                <th class="projectCreator"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->creator)); ?></th>
                <th class="projectOverseer"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->overseer)); ?></th>
                <th class="projectAction"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
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