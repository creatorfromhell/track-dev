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
require_once("include/function/listfunc.php");
require_once("include/function/userfunc.php");
class ProjectFunc {

    //add project
    public static function add($project, $preset, $main, $creator, $created, $overseer, $public) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, project, preset, main, creator, created, overseer, public) VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $preset);
        $stmt->bindParam(3, $main);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $overseer);
        $stmt->bindParam(7, $public);
        $stmt->execute();
    }

    public static function remove($id) {
        $project = self::getName($id);
        $lists = self::lists($project);
        foreach($lists as &$list) {
            $listid = ListFunc::getID($project, $list);
            ListFunc::remove($listid);
        }
        self::delete($id);
    }

    //delete project
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit project
    public static function edit($id, $project, $preset, $main, $overseer, $public) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET project = ?, preset = ?, main = ?, overseer = ?, public = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $preset);
        $stmt->bindParam(3, $main);
        $stmt->bindParam(4, $overseer);
        $stmt->bindParam(5, $public);
        $stmt->bindParam(6, $id);
        $stmt->execute();
    }

    //get project id
    public static function getID($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE project = ?");
        $stmt->bindParam(1, $project);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    //change main list id
    public static function changeMain($id, $main) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET main = ? WHERE id = ?");
        $stmt->bindParam(1, $main);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //get main list id
    public static function getMain($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT main FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['main'];
    }

    public static function getMainList($project) {
        $id = self::getID($project);
        $listID = self::getMain($id);
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT list FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $listID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['list'];
    }

    //get overseer
    public static function getOverseer($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT overseer FROM `".$t."` WHERE project = ?");
        $stmt->bindParam(1, $project);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['overseer'];
    }

    //change overseer
    public static function changeOverseer($id, $overseer) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET overseer = ? WHERE id = ?");
        $stmt->bindParam(1, $overseer);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    public static function getName($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT project FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['project'];
    }

    //get preset project
    public static function getPreset() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT project FROM `".$t."` WHERE preset = 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['project'];
    }

    //make preset project
    public static function makePreset($id) {
        self::removePreset();
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET preset = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public static function removePreset() {
        $presetID = self::getID(self::getPreset());
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET preset = 0 WHERE id = ?");
        $stmt->bindParam(1, $presetID);
        $stmt->execute();
    }

    //make project private
    public static function makePrivate($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET public = 0 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //make project public
    public static function makePublic($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET public = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public static function getDetails($id) {
        $return = array();
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT project, preset, main, creator, created, overseer, public FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $return['name'] = $result['project'];
        $return['preset'] = $result['preset'];
        $return['main'] = $result['main'];
        $return['creator'] = $result['creator'];
        $return['created'] = $result['created'];
        $return['overseer'] = $result['overseer'];
        $return['public'] = $result['public'];

        return $return;
    }

    //reproject project
    public static function rename($id, $oldname, $project) {
        $lists = self::lists($oldname);
        foreach($lists as &$list) {
            ListFunc::changeProject(ListFunc::getID($oldname, $list), $project);
        }
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE `".$t."` SET project = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //exists
    public static function exists($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE project = ?");
        $stmt->bindParam(1, $project);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
    }

    public static function hasProjects() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT id FROM `".$t."`");
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_NUM) > 0) {
            return true;
        }
        return false;
    }

    public static function printProjects($username, $formatter) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT id, project, creator, created, overseer FROM `".$t."`");
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['project'];
            $creator = $row['creator'];
            $created = $row['created'];
            $overseer = $row['overseer'];
            $canEdit = UserFunc::isAdmin($username);

            echo "<tr>";
            echo "<td class='name'><a href='lists.php?p=".$name."'>".$formatter->replace($name)."</a></td>";
            echo "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";
            echo "<td class='creator'>".$formatter->replace($creator)."</td>";
            echo "<td class='overseer'>".$formatter->replace($overseer)."</td>";
            echo "<td class='actions'>";

            if($canEdit) {
                echo "<a title='Edit' class='actionEdit' href='?action=edit&id=".$id."'></a>";
                echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete project ".$name."?\");' href='?action=delete&id=".$id."'></a>";
            } else {
                echo $formatter->replace("%none");
            }

            echo "</td>";
            echo "</tr>";
        }
    }

    public static function hasLists($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE project = ?");
        $stmt->bindParam(1, $project);
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_NUM) > 0) {
            return true;
        }
        return false;
    }

    public static function printLists($project, $username, $formatter) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT id, list, created, creator, overseer FROM `".$t."` WHERE project = ?");
        $stmt->bindParam(1, $project);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['list'];
            $created = $row['created'];
            $creator = $row['creator'];
            $overseer = $row['overseer'];
            $canEdit = UserFunc::canEdit($project, $name, $username);

            echo "<tr>";
            echo "<td class='name'><a href='list.php?p=".$project."&amp;l=".$name."'>".$formatter->replace($name)."</a></td>";
            echo "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";
            echo "<td class='creator'>".$formatter->replace($creator)."</td>";
            echo "<td class='overseer'>".$formatter->replace($overseer)."</td>";
            echo "<td class='actions'>";

            if($canEdit) {
                echo "<a title='Edit' class='actionEdit' href='?p=".$project."&action=edit&id=".$id."'></a>";
                echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure you want to delete list ".$name."?\");' href='?p=".$project."&action=delete&id=".$id."'></a>";
            } else {
                echo $formatter->replace("%none");
            }

            echo "</td>";
            echo "</tr>";
        }
    }

    public static function projects() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT project FROM `".$t."`");
        $stmt->execute();
        $result = $stmt->fetchAll();

        $projects = array();
        for($i = 0; $i < count($result); $i++) {
            $project = $result[$i];
            $projects[$i] = $project[0];
        }

        return $projects;
    }

    public static function lists($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("SELECT list FROM `".$t."` WHERE project = ?");
        $stmt->bindParam(1, $project);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $lists = array();
        for($i = 0; $i < count($result); $i++) {
            $list = $result[$i];
            $lists[$i] = $list[0];
        }

        return $lists;
    }

    public static function latestTasks($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $lists = self::lists($project);
        $from = "";

        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT title, created FROM `".$connect->prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $c->prepare("SELECT title FROM (".$from.") AS a ORDER BY created DESC LIMIT 7");
        $stmt->execute();
        $result = $stmt->fetchAll();

        $tasks = array();
        for($i = 0; $i < count($result); $i++) {
            $task = $result[$i];
            $tasks[$i] = $task[0];
        }
        return $tasks;
    }

    public static function getTasksChartData($project, $months, $completed) {
        $monthData = '';
        $totalData = "";
        $completedData = "";
        if($months) {
            for ($i = -6; $i <= 0; $i++){
                if( $i > -6) { $monthData .= ','; }
                $monthData .= '"'.date('M', strtotime("$i month")).'"';
            }
            return $monthData;
        } else {
            if($completed) {
                for ($i = -6; $i <= 0; $i++){
                    if( $i > -6) { $completedData .= ","; }
                    $completedData .= self::getTaskCountByMonth($project, date('m', strtotime("$i month")), true);
                }
                return $completedData;
            }
            for ($i = -6; $i <= 0; $i++){
                if( $i > -6) { $totalData .= ","; }
                $totalData .= self::getTaskCountByMonth($project, date('m', strtotime("$i month")), false);
            }
            return $totalData;
        }
    }

    public static function getTaskCountByMonth($project, $month, $completed) {
        $connect = new Connect();
        $c = $connect->connection;
        $lists = self::lists($project);

        $from = "";
        if($completed) {
            for($i = 0; $i < count($lists); $i++) {
                if($i > 0) { $from .= " UNION ALL "; }
                $from .= "SELECT title, EXTRACT(YEAR FROM finished) AS year, EXTRACT(MONTH FROM finished) AS month FROM `".$connect->prefix."_".$project."_".$lists[$i]."` WHERE taskstatus = 1";
            }
            $stmt = $c->prepare("SELECT COUNT(*) FROM (".$from.") AS a WHERE year = ".date("Y")." AND month = ".$month);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return ($result) ? $result : 0;
        }
        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT title, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month FROM `".$connect->prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $c->prepare("SELECT COUNT(*) FROM (".$from.") AS a WHERE year = ".date("Y")." AND month = ".$month);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return ($result) ? $result : 0;
    }

    public static function getAssignedUsersChartData($project, $users, $completed) {
        $dataArray = self::getTopAssignedUsers($project);
        $userArray = $dataArray[0];
        $totalArray = $dataArray[1];
        $completedArray = $dataArray[2];

        if($users) {
            $userString = "";
            for($i = 0; $i < count($userArray); $i++) {
                if( $i > 0) { $userString .= ","; }
                $userString .= "'".$userArray[$i]."'";
            }
            return $userString;
        } else {
            if($completed) {
                $completedString = "";
                for($i = 0; $i < count($completedArray); $i++) {
                    if( $i > 0) { $completedString .= ","; }
                    $completedString .= $completedArray[$i];
                }
                return $completedString;
            } else {
                $totalString = "";
                for($i = 0; $i < count($totalArray); $i++) {
                    if( $i > 0) { $totalString .= ","; }
                    $totalString .= $totalArray[$i];
                }
                return $totalString;
            }
        }
    }

    public static function getTopAssignedUsers($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $lists = self::lists($project);
        $users = array();
        $totals = array();
        $completed = array();

        $from = "";
        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT id, assignee FROM `".$connect->prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $c->prepare("SELECT assignee, Count(a.id) AS total FROM(".$from.") AS a GROUP BY assignee ORDER BY total DESC LIMIT 5");
        $stmt->execute();
        $id = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[$id] = $row['assignee'];
            $totals[$id] = $row['total'];
            $id++;
        }

        for($i = 0; $i < count($users); $i++) {
            $from = "";
            for($i2 = 0; $i2 < count($lists); $i2++) {
                if($i2 > 0) { $from .= " UNION ALL "; }
                $from .= "SELECT id FROM `".$connect->prefix."_".$project."_".$lists[$i2]."` WHERE assignee = '".$users[$i]."' AND taskstatus = 1";
            }
            $stmt = $c->prepare("SELECT Count(a.id) FROM(".$from.") AS a");
            $stmt->execute();
            $result = $stmt->fetchColumn();
            $completed[$i] = ($result) ? $result : 0;
        }
        return array($users, $totals, $completed);
    }

    public static function hasEvent($project, $year, $month, $day) {
        $connect = new Connect();
        $c = $connect->connection;
        $lists = self::lists($project);

        $stmt = $c->prepare("SELECT COUNT(*) FROM (SELECT id, project, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month, EXTRACT(DAY FROM created) AS day FROM `".$connect->prefix."_lists`) AS a WHERE project = ".$project." AND year = ".$year." AND month = ".$month." AND day = ".$day);
        $stmt->execute();
        if($stmt->fetchColumn()) {
            return true;
        }

        $from = "";
        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT id, EXTRACT(YEAR FROM due) AS year, EXTRACT(MONTH FROM due) AS month, EXTRACT(DAY FROM due) AS day FROM `".$connect->prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $c->prepare("SELECT COUNT(*) FROM (".$from.") AS a WHERE year = ".$year." AND month = ".$month." AND day = ".$day);
        $stmt->execute();
        if($stmt->fetchColumn()) {
            return true;
        }
        return false;
    }

    public static function getEvents($project, $year, $month, $day) {
        $connect = new Connect();
        $c = $connect->connection;
        $lists = self::lists($project);
        $toReturn = "";
        if(self::hasEvent($project, $year, $month, $day)) {
            $toReturn .= "<ul>";

            $stmt = $c->prepare("SELECT name, author FROM (SELECT id, name, author, project, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month, EXTRACT(DAY FROM created) AS day FROM `".$connect->prefix."_lists`) AS a WHERE project = ".$project." AND year = ".$year." AND month = ".$month." AND day = ".$day);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $toReturn .= '<li>List: <a href="list.php?p='.$project.'&list='.$row['name'].'">'.$row['name'].'</a>, was created by '.$row['author'].'.</li>';
            }

            $from = "";
            for($i = 0; $i < count($lists); $i++) {
                if($i > 0) { $from .= " UNION ALL "; }
                $from .= "SELECT id, title, author, EXTRACT(YEAR FROM due) AS year, EXTRACT(MONTH FROM due) AS month, EXTRACT(DAY FROM due) AS day FROM `".$connect->prefix."_".$project."_".$lists[$i]."`";
            }
            $stmt = $c->prepare("SELECT id, title, author FROM (".$from.") AS a WHERE year = ".$year." AND month = ".$month." AND day = ".$day);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $toReturn .= '<li>Task: '.$row['title'].' was created by '.$row['author'].'.</li>';
            }
            $toReturn .= "</ul>";
        } else {
            $toReturn .= "<p>This calendar has no events.</p>";
        }
        return $toReturn;
    }

    public static function getCorrectDate($year, $month, $day) {
        $newYear = $year;
        $newMonth = $month;
        $newDay = $day;
        $newTime = mktime(0, 0, 0, $newMonth, $newDay, $newYear);

        if($newDay < 1 || $newDay > date('t', $newTime)) {
            if($newDay < 1) {
                $newMonth--;
                $newDay = date('t', mktime(0, 0, 0, $newMonth, 1, $newYear));
            } else {
                $newMonth++;
                $newDay = 1;
            }
        }

        if($newMonth < 1 || $newMonth > 12) {
            if($newMonth < 1) {
                $newMonth = 12;
                $newYear--;
            } else {
                $newMonth = 1;
                $newYear++;
            }
        }
        $newTime = mktime(0, 0, 0, $newMonth, $newDay, $newYear);
        return $newTime;
    }

    public static function printEditForm($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT project, main, overseer, public FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $out = '';
        $out .= '<form id="project_edit" class="trackrForm" method="post">';
        $out .= '<h3>Edit Project</h3>';
        $out .= '<div id="holder">';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input id="id" name="id" type="hidden" value="'.$id.'">';
        $out .= '<input id="name" name="name" type="text" placeholder="Name" value="'.$result['project'].'">';
        $out .= '<label for="public">Public:</label>';
        $out .= '<select name="public" id="public">';
        $out .= '<option value="0" ';
        $out .= ($result["public"] == 0) ? "selected" : "";
        $out .= '>No</option>';
        $out .= '<option value="1" ';
        $out .= ($result["public"] == 1) ? "selected" : "";
        $out .= '>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="mainlist">Main List:</label>';
        $out .= '<select name="mainlist" id="mainlist">';
        $lists = self::lists($result['project']);
        foreach($lists as &$list) {
            $listID = ListFunc::getID($result['project'], $list);
            $selected = ($listID == $result['main']) ? "selected" : "";
            $out .= '<option value="'.$listID.'" '.$selected.'>'.$list.'</option>';
        }
        $out .= '</select><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button id="submit_2" onclick="hideDiv(\'project_edit\'); return false;">Close</button>';
        $out .= '<button id="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_2">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="mainproject">Main:</label>';
        $out .= '<select name="mainproject" id="mainproject">';
        $out .= '<option value="0" ';
        $out .= ($result["main"] == 0) ? "selected" : "";
        $out .= '>No</option>';
        $out .= '<option value="1" ';
        $out .= ($result["main"] == 1) ? "selected" : "";
        $out .= '>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="overseer">Overseer:</label>';
        $out .= '<select name="overseer" id="overseer">';
        $selected = ($result['overseer'] == 'none') ? 'selected' : '';
        $out .= '<option value="none" '.$selected.'>None</option>';
        $users = UserFunc::users();
        foreach($users as &$user) {
            $selected = ($result['overseer'] == $user) ? 'selected' : '';
            $out .= '<option value="'.$user.'" '.$selected.'>'.$user.'</option>';
        }
        $out .= '</select>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button id="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
        $out .= '<input type="submit" id="submit" name="edit" value="Submit">';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</form>';

        return $out;
    }
}
?>