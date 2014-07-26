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
        <?php
        $id = 0;
        $editing = false;
        if(isset($_GET['action']) && isset($_GET['id'])) {
            $action = $_GET['action'];
            $id = $_GET['id'];
            if(UserFunc::isAdmin($username) || ListFunc::getOverseer($id) == $username || ProjectFunc::getOverseer(ListFunc::getProject($id)) == $username) {
                if($action == "delete") {
                    $name = ListFunc::getName($id);
                    ListFunc::remove($id);
                    $params = "id:".$id;
                    ActivityFunc::log($username, $project, $name, "list:delete", $params, 0, date("Y-m-d H:i:s"));
                    echo '<script type="text/javascript">';
                    echo 'showMessage("success", "List '.$name.' has been deleted.");';
                    echo '</script>';
                } else if($action == "edit") {
                    $editing = true;
                }
            }
        }
        ?>
        <?php if(UserFunc::isAdmin($username) || ProjectFunc::getOverseer($project) == $username) { ?>
            <!-- List Form -->
            <form id="list_form" class="trackrForm" method="post" action="lists.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>">
                <?php
                if(!$editing) {
                    echo ListFunc::printAddForm($project, $projects, $username);
                } else {
                    echo ListFunc::printEditForm($id, $username);
                }
                ?>
        <?php } ?>

        <!-- Lists -->
        <?php
        if(ProjectFunc::hasLists($project)) {
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
                ProjectFunc::printLists($project, $username, $formatter);
                ?>
            </tbody>
        </table>
        <?php
        } else {
            echo "<p class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->nolist))."</p>";
        }
        ?>
    </div>

<?php
include("include/footer.php");
?>