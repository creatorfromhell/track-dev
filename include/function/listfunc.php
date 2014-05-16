<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("include/connect.php");
class ListFunc {

    //add list
    public static function add($list, $project, $public, $creator, $created, $overseer, $minimal, $guestview, $guestedit, $viewpermission, $editpermission) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, list, project, public, creator, created, overseer, minimalview, guestview, guestedit, viewpermission, editpermission) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $list);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $public);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $overseer);
        $stmt->bindParam(7, $minimal);
        $stmt->bindParam(8, $guestview);
        $stmt->bindParam(9, $guestedit);
        $stmt->bindParam(10, $viewpermission);
        $stmt->bindParam(11, $editpermission);
        $stmt->execute();
    }

    public static function create($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $c->exec("CREATE TABLE IF NOT EXISTS `".$t."` (
                              `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                              `title` varchar(40) NOT NULL,
                              `description` text NOT NULL,
                              `author` varchar(40) NOT NULL,
                              `assignee` varchar(40) NOT NULL,
                              `due` date NOT NULL DEFAULT '0000-00-00',
                              `created` date NOT NULL DEFAULT '0000-00-00',
                              `finished` date NOT NULL DEFAULT '0000-00-00',
                              `versionname` varchar(40) NOT NULL,
                              `labels` text NOT NULL,
                              `editable` tinyint(1) NOT NULL DEFAULT '1',
                              `taskstatus` tinyint(3) NOT NULL DEFAULT '0',
                              `progress` tinyint(3) NOT NULL DEFAULT '0'
                            );");
    }

    public static function remove($id) {
        $project = self::getProject($id);
        $list = self::getName($id);
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("DROP TABLE IF EXISTS `".$t."`");
        $stmt->execute();
        self::delete($id);
    }

    //delete list
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit list
    public static function edit($id, $list, $project, $public, $creator, $created, $overseer, $minimal, $guestview, $guestedit, $viewpermission, $editpermission) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE `".$t."` SET list = ?, project = ?, public = ?, creator = ?, created = ?, overseer = ?, minimalview = ?, guestview = ?, guestedit = ?, viewpermission = ?, editpermission = ? WHERE id = ?");
        $stmt->bindParam(1, $list);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $public);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $overseer);
        $stmt->bindParam(7, $minimal);
        $stmt->bindParam(8, $guestview);
        $stmt->bindParam(9, $guestedit);
        $stmt->bindParam(10, $viewpermission);
        $stmt->bindParam(11, $editpermission);
        $stmt->bindParam(12, $id);
        $stmt->execute();
    }

    //return all the configuration options for this list
    public static function configurations($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT public, minimalview, guestview, guestedit, viewpermission, editpermission FROM `".$t."` WHERE list = ? AND project = ?");
        $stmt->bindParam(1, $list);
        $stmt->bindParam(2, $project);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function guestView($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT guestview FROM `".$t."` WHERE project = ? AND list = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['guestview'] == '1') {
            return true;
        }
        return false;
    }

    public static function guestEdit($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT guestedit FROM `".$t."` WHERE project = ? AND list = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['guestedit'] == '1') {
            return true;
        }
        return false;
    }

    public static function editPermission($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT editpermission FROM `".$t."` WHERE project = ? AND list = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['editpermission'];
    }

    public static function viewPermission($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT viewpermission FROM `".$t."` WHERE project = ? AND list = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['viewpermission'];
    }

    //Check if the list has any tasks
    public static function isEmpty($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("SELECT id FROM `".$t."` ORDER BY taskstatus, id");
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_NUM) > 0) {
            return false;
        }
        return true;
    }

    //Print out the tasks for the specified list
    public static function printTasks($project, $list, $formatter, $minimal, $canEdit, $username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_".$project."_".$list;
        $stmt = $c->prepare("SELECT id, title, author, assignee, created, editable, taskstatus FROM `".$t."` ORDER BY taskstatus, id");
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $title = $row['title'];
            $author = $row['author'];
            $assignee = $row['assignee'];
            $created = $row['created'];
            $editable = $row['editable'];
            $status = $row['taskstatus'];

            if($status == "0") { echo "<tr>"; }
            else if($status == "1") { echo "<tr class='done'>"; }
            else if($status == "2") { echo "<tr class='inprogress'>"; }
            else if($status == "3") { echo "<tr class='closed'>"; }
            else { echo "<tr>"; }

            echo "<td class='id'>".$id."</td>";
            echo "<td class='title'><a href='#'>".$formatter->replace($title)."</a></td>";
            if(!$minimal) {
                //assignee
                echo "<td class='assignee'>".$formatter->replace($assignee)."</td>";

                //created
                echo "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";

                //author
                echo "<td class='author'>".$formatter->replace($author)."</td>";
            }


            echo "<td class='actions'>";
            if($canEdit && $editable == "1") {
                self::printActions($project, $list, $id, $status);
            } else {
                if($author == $username || UserFunc::isAdmin($username)) {
                    self::printActions($project, $list, $id, $status);
                } else {
                    echo $formatter->replace("%none");
                }
            }

            echo "</td>";
            echo "</tr>";
        }
    }

    //echo out the task's actions
    public static function printActions($project, $list, $id, $status) {
        $basic = "p=".$project."&l=".$list;
        $open = "<a title='Open' class='actionOpen' href='?".$basic."&action=open&amp;id=".$id."'></a>";
        $done = "<a title='Done' class='actionDone' href='?".$basic."&action=done&amp;id=".$id."'></a>";
        $inprogress = "<a title='In Progress' class='actionProgress' href='?".$basic."&action=inprogress&amp;id=".$id."'></a>";
        $close = "<a title='Close' class='actionClose' href='?".$basic."&action=close&amp;id=".$id."'></a>";

        if($status != "0") { echo $open; }
        if($status != "1") { echo $done; }
        if($status != "2") { echo $inprogress; }
        if($status != "3") { echo $close; }

        echo "<a title='Edit' class='actionEdit' onclick='editTask(); return false;'></a>";
        echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete task #".$id."?\");' href='?".$basic."&action=delete&amp;id=".$id."'></a>";
        //echo "<a title='Move Up' class='actionUp' href='?".$basic."&action=up&amp;id=".$id."'></a>";
        //echo "<a title='Move Down' class='actionDown' href='?".$basic."&action=down&amp;id=".$id."'></a>";
    }

    //get list id
    public static function getID($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE list = ? AND project = ?");
        $stmt->bindParam(1, $list);
        $stmt->bindParam(2, $project);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }

    public static function getDetails($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT list, project, public, creator, created, overseer FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['project'];
    }

    public static function minimal($list, $project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT minimalview FROM `".$t."` WHERE list = ? AND project = ?");
        $stmt->bindParam(1, $list);
        $stmt->bindParam(2, $project);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result['minimalview'] != 0) ? true : false;
    }

    public static function getOverseer($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT overseer FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['overseer'];
    }

    public static function getProject($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT project FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['project'];
    }

    //change list project
    public static function changeProject($id, $project) {
        $details = self::getDetails($id);
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE `".$t."` SET project = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $t = $connect->prefix."_".$details['project']."_".$details['list'];
        $t2 = $connect->prefix."_".$project."_".$details['list'];
        $stmt = $c->prepare("RENAME TABLE `".$t."` TO ".$t2);
        $stmt->execute();
    }

    //make list private
    public static function makePrivate($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE `".$t."` SET public = 0 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public static function getName($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT list FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['list'];
    }

    //make list public
    public static function makePublic($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE `".$t."` SET public = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //relist list
    public static function rename($id, $list) {
        $details = self::getDetails($id);
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE `".$t."` SET list = ? WHERE id = ?");
        $stmt->bindParam(1, $list);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $t = $connect->prefix."_".$details['project']."_".$details['list'];
        $t2 = $connect->prefix."_".$details['project']."_".$list;
        $stmt = $c->prepare("RENAME TABLE `".$t."` TO ".$t2);
        $stmt->execute();
    }

    //exists
    public static function exists($project, $list) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE project = ? AND list = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
    }
}
?>