<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 6:53 PM
 * Version: Beta 1
 * Last Modified: 8/7/14 at 6:53 PM
 * Last Modified by Daniel Vidmar.
 */
include_once("include/handling/user.php");
$editing = false;
$subPage = "all";
if(isset($_GET['sub'])) {
    $subPage = $_GET['sub'];
}
if(isset($_GET['action'])) {
    $action = cleanInput($_GET['action']);

    if($action == "edit" && isset($_GET['id']) && User::exists(User::getName(cleanInput($_GET['id'])))) {
        $editing = true;
    } else if($action == "delete" && isset($_GET['id']) && User::exists(User::getName(cleanInput($_GET['id'])))) {
        $params = "id:".$id.",status:".$action;
        ActivityFunc::log(getName(), $project, $list, "user:delete", $params, 0, date("Y-m-d H:i:s"));
        echo '<script type="text/javascript">';
        echo 'showMessage("success", "User '.User::getName(cleanInput($_GET['id'])).' has been delete.");';
        echo '</script>';
        User::delete(cleanInput($_GET['id']));
    }
}

if($subPage == "user" && isset($_GET['name']) && User::exists($_GET['name'])) {
?>
<div id="user-view">

</div>
<?php
} else {
    global $prefix;
    $pagination = new Pagination($prefix."_users", "id, user_name, user_email, user_group, user_registered", $pn, 10, "?t=".$type."&amp;");
?>

<form method="post" action="admin.php?t=users">
    <h3><?php echo ($editing) ? "Edit User" : "Add User"; ?></h3>
    <div id="form-holder">
        <?php
        if($editing) {
            $user = User::load(cleanInput($_GET['id']), false, true);
        ?>
            <div id="page_1" class="form-page">
                <fieldset id="inputs">
                    <input id="id" name="id" type="hidden" value="<?php echo $user->id; ?>">
                    <input id="username" name="username" type="text" value="<?php echo $user->name; ?>" placeholder="Username">
                    <input id="email" name="email" type="text" value="<?php echo $user->email; ?>" placeholder="User Email">
                    <input id="password" name="password" type="password" placeholder="User Password">
                    <input id="c_password" name="c_password" type="password" placeholder="Confirm Password">
                </fieldset>
                <fieldset id="links">
                    <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
                </fieldset>
            </div>
            <div id="page_2" class="form-page">
                <fieldset id="inputs">
                    <label for="group">Group: </label>
                    <select name="group" id="group">
                        <?php
                        global $prefix, $pdo;
                        $t = $prefix."_groups";
                        $stmt = $pdo->prepare("SELECT id, group_name FROM `".$t."`");
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='".$row['id']."'".(($row['id'] == $user->group->id) ? " selected" : "").">".$row['group_name']."</option>";
                        }
                        ?>
                    </select><br />
                    <div class="pick-field">
                        <div class="title">Permissions</div>
                        <div class="column-titles">
                            <label class="fmleft">Available</label>
                            <label class="fmright">Added</label>
                            <div class="clear"></div>
                        </div>
                        <?php $added = array(); ?>
                        <div id="permissions-available" class="column-left" ondrop="onDrop(event, 'permissions-value', 'remove')" ondragover="onDragOver(event)">
                            <?php
                            global $prefix, $pdo;
                            $t = $prefix."_nodes";
                            $stmt = $pdo->prepare("SELECT id, node_name FROM `".$t."`");
                            $stmt->execute();
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                if(in_array($row['id'], $user->permissions)) {
                                    $added[] = '<div id="node-'.$row['id'].'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$row['node_name'].'</div>';
                                } else {
                                    echo '<div id="node-'.$row['id'].'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$row['node_name'].'</div>';
                                }
                            }
                            ?>
                        </div>
                        <div id="permissions-added" class="column-right" ondrop="onDrop(event, 'permissions-value', 'add')" ondragover="onDragOver(event)">
                            <?php
                            foreach($added as &$a) {
                                echo $a;
                            }
                            ?>
                        </div>
                        <input id="permissions-value" name="permissions-value" type="hidden" value="">
                    </div>
                    <?php
                    $captcha = new Captcha();
                    $captcha->printImage();
                    $_SESSION['userspluscaptcha'] = $captcha->code;
                    ?>
                    <br />
                    <input id="captcha" name="captcha" type="text" placeholder="Enter characters above">
                </fieldset>
                <fieldset id="links">
                    <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                    <input type="submit" class="submit" name="edit_user" value="Edit">
                </fieldset>
            </div>
        <?php
        } else {
        ?>
        <div id="page_1" class="form-page">
            <fieldset id="inputs">
                <input id="username" name="username" type="text" placeholder="Username">
                <input id="email" name="email" type="text" placeholder="User Email">
                <input id="password" name="password" type="password" placeholder="User Password">
                <input id="c_password" name="c_password" type="password" placeholder="Confirm Password">
            </fieldset>
            <fieldset id="links">
                <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_2" class="form-page">
            <fieldset id="inputs">
                <label for="group">Group: </label>
                <select name="group" id="group">
                <?php
                    global $prefix, $pdo;
                    $t = $prefix."_groups";
                    $stmt = $pdo->prepare("SELECT id, group_name FROM `".$t."`");
                    $stmt->execute();
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['id']."'".(($row['id'] == Group::preset()) ? " selected" : "").">".$row['group_name']."</option>";
                    }
                ?>
                </select><br />
                <div class="pick-field">
                    <div class="title">Permissions</div>
                    <div class="column-titles">
                        <label class="left">Available</label>
                        <label class="right">Added</label>
                        <div class="clear"></div>
                    </div>
                    <div id="permissions-available" class="column-left" ondrop="onDrop(event, 'permissions-value', 'remove')" ondragover="onDragOver(event)">
                        <?php
                        global $prefix, $pdo;
                        $t = $prefix."_nodes";
                        $stmt = $pdo->prepare("SELECT id, node_name FROM `".$t."`");
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<div id="node-'.$row['id'].'" class="draggable-node" draggable="true" ondragstart="onDrag(event)">'.$row['node_name'].'</div>';
                        }
                        ?>
                    </div>
                    <div id="permissions-added" class="column-right" ondrop="onDrop(event, 'permissions-value', 'add')" ondragover="onDragOver(event)">

                    </div>
                    <input id="permissions-value" name="permissions-value" type="hidden" value="">
                </div>
                <?php
                $captcha = new Captcha();
                $captcha->printImage();
                $_SESSION['userspluscaptcha'] = $captcha->code;
                ?>
                <br />
                <input id="captcha" name="captcha" type="text" placeholder="Enter characters above">
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <input type="submit" class="submit" name="add_user" value="Add">
            </fieldset>
        </div>
        <?php
        }
        ?>
    </div>
</form>
<?php
    echo $pagination->pageString;
?>
<table id="users" class="taskTable">
    <thead>
    <tr>
        <th id="userName" class="large"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->name)); ?></th>
        <th id="userEmail" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->email)); ?></th>
        <th id="userGroup" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->group)); ?></th>
        <th id="userRegister" class="medium"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->registered)); ?></th>
        <th id="userAction" class="action"><?php echo $formatter->replaceShortcuts(((string)$languageinstance->site->tables->actions)); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
        $users = $pagination->paginateReturn();
        foreach($users as &$u) {
            $g = Group::load($u['user_group'])->name;
            echo "<tr>";
            echo "<td>".$u['user_name']."</td>";
            echo "<td>".$u['user_email']."</td>";
            echo "<td>".$g."</td>";
            echo "<td>".$u['user_registered']."</td>";
            echo "<td class='actions'>";
            echo "<a title='Edit' class='actionEdit' href='?t=users&amp;action=edit&amp;id=".$u['id']."&amp;pn=".$pn."'></a>";
            echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete user ".$u['user_name']."?\");' href='?t=users&amp;action=delete&amp;id=".$u['id']."&amp;pn=".$pn."'></a>";
            echo "</td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>
<?php
}
?>