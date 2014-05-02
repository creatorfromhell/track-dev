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
include("include/handling/listform.php");
?>

    <div id="main">
        <!-- Add List -->
        <?php if(UserFunc::isAdmin($username) || ProjectFunc::getOverseer($project) == $username) { ?>
        <form id="list_add" method="post">
            <h3>Add List</h3>
            <div id="holder">
                <div id="page_1">
                    <fieldset id="inputs">
                        <input id="name" name="name" type="text" placeholder="Name">
                        <input id="author" name="author" type="hidden" value="<?php echo $username; ?>">
                        <label for="project">Project:</label>
                        <select name="project" id="project">
                            <?php
                                foreach($projects as &$p) {
                                    echo '<option value="'.$p.'">'.$p.'</option>';
                                }
                            ?>
                        </select><br />
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
                        <label for="minimal">Minimal View:</label>
                        <select name="minimal" id="minimal">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select><br />
                        <label for="mainlist">Main:</label>
                        <select name="mainlist" id="mainlist">
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
                        <button id="submit" onclick="switchPage(event, 'page_2', 'page_3'); return false;">Next</button>
                    </fieldset>
                </div>
                <div id="page_3">
                    <fieldset id="inputs">
                        <label for="guestview">Guest View:</label>
                        <select name="guestview" id="guestview">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select><br />
                        <label for="guestedit">Guest Edit:</label>
                        <select name="guestedit" id="guestedit">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select><br />
                        <label for="viewpermission">View Permission:</label>
                        <?php //TODO: add viewpermission field ?>
                        <label for="editpermission">Edit Permission:</label>
                        <?php //TODO: add editpermission field ?>
                    </fieldset>
                    <fieldset id="links">
                        <button id="submit_2" onclick="switchPage(event, 'page_3', 'page_2'); return false;">Back</button>
                        <input type="submit" id="submit" name="add" value="Add">
                    </fieldset>
                </div>
            </div>
        </form>
        <?php } ?>

        <!-- Lists -->
        <?php
        if(ProjectFunc::hasLists($project)) {
        ?>
        <table id="lists">
            <thead>
                <tr>
                    <th class="listName"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->list)); ?></th>
                    <th class="listCreated"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->created)); ?></th>
                    <th class="listCreator"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->creator)); ?></th>
                    <th class="listOverseer"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->overseer)); ?></th>
                    <th class="listAction"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                ProjectFunc::printLists($project, $username, $formatter);
                ?>
            </tbody>
        </table>
        <?php
        } else {
            echo "<p>".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->nolist))."</p>";
        }
        ?>
    </div>

<?php
include("include/footer.php");
?>