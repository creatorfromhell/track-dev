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
            if(isAdmin() || ProjectFunc::getOverseer(ListFunc::getProject($id)) == getName()) {
                if($action == "delete") {
                    $name = ListFunc::getName($id);
                    ListFunc::remove($id);
                    $params = "id:".$id;
                    ActivityFunc::log(getName(), $project, $name, "list:delete", $params, 0, date("Y-m-d H:i:s"));
                    echo '<script type="text/javascript">';
                    echo 'showMessage("success", "List '.$name.' has been deleted.");';
                    echo '</script>';
                } else if($action == "edit") {
                    $editing = true;
                }
            }
        }
        ?>
        <?php if(isAdmin() || ProjectFunc::getOverseer($project) == getName()) { ?>
            <!-- List Form -->
            <form id="list_form" class="trackrForm" method="post" action="lists.php?p=<?php echo $project; ?>&l=<?php echo $list; ?>">
                <?php
                if(!$editing) {
                    echo ListFunc::printAddForm($project, $projects, getName());
                } else {
                    echo ListFunc::printEditForm($id);
                }
                ?>
        <?php } ?>

        <!-- Lists -->
        <?php
        if(ProjectFunc::hasLists($project)) {
            global $prefix;
            $pagination = new Pagination($prefix."_lists", "id, list, created, creator, overseer", $pn, 10);
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
                echo "<td class='overseer'>".$formatter->replace($overseer)."</td>";
                if(isAdmin() || ProjectFunc::getOverseer(ListFunc::getProject($id)) == getName()) {
                    echo "<a title='Edit' class='actionEdit' href='?p=".$project."&action=edit&id=".$id."'></a>";
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
            echo "<p class=\"announce\">".$formatter->replaceShortcuts(((string)$languageinstance->site->tables->nolist))."</p>";
        }
        ?>
    </div>

<?php
include("include/footer.php");
?>