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
require_once("include/function/userfunc.php");
class ProjectFunc {

    //add project
    public static function add($project, $preset, $main, $creator, $created, $overseer, $public) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, project, preset, main, creator, created, overseer, public) VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $preset);
        $stmt->bindParam(3, $main);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $overseer);
        $stmt->bindParam(7, $public);
        $stmt->execute();
    }

    //delete project
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit project
    public static function edit($id, $project, $preset, $main, $creator, $created, $overseer, $public) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET project = ?, preset = ?, main = ?, creator = ?, created = ?, overseer = ?, public = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $preset);
        $stmt->bindParam(3, $main);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $overseer);
        $stmt->bindParam(7, $public);
        $stmt->bindParam(8, $id);
        $stmt->execute();
    }

    //get project id
    public static function getID($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT id FROM ".$t." WHERE project = ?");
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
        $stmt = $c->prepare("UPDATE ".$t." SET main = ? WHERE id = ?");
        $stmt->bindParam(1, $main);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //get main list id
    public static function getMain($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT main FROM ".$t." WHERE id = ?");
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
        $stmt = $c->prepare("SELECT list FROM ".$t." WHERE id = ?");
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
        $stmt = $c->prepare("SELECT overseer FROM ".$t." WHERE project = ?");
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
        $stmt = $c->prepare("UPDATE ".$t." SET overseer = ? WHERE id = ?");
        $stmt->bindParam(1, $overseer);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //get preset project
    public static function getPreset() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT project FROM ".$t." WHERE preset = 1");
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
        $stmt = $c->prepare("UPDATE ".$t." SET preset = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public static function removePreset() {
        $presetID = self::getID(self::getPreset());
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET preset = 0 WHERE id = ?");
        $stmt->bindParam(1, $presetID);
        $stmt->execute();
    }

    //make project private
    public static function makePrivate($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET public = 0 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //make project public
    public static function makePublic($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET public = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //reproject project
    public static function rename($id, $project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET project = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //exists
    public static function exists($project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("SELECT id FROM ".$t." WHERE project = ?");
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
        $stmt = $c->prepare("SELECT id FROM ".$t);
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
        $stmt = $c->prepare("SELECT id, project, creator, created, overseer FROM ".$t);
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
                echo "<a title='Edit' class='actionEdit' onclick='editTask(); return false;'></a>";
                echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?action=delete&id=".$id."'></a>";
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
        $stmt = $c->prepare("SELECT id FROM ".$t." WHERE project = ?");
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
        $stmt = $c->prepare("SELECT id, list, created, creator, overseer FROM ".$t." WHERE project = ?");
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
            echo "<td class='name'><a href='list.php?p=".$project."&l=".$name."'>".$formatter->replace($name)."</a></td>";
            echo "<td class='created'>".$formatter->replace($formatter->formatDate($created))."</td>";
            echo "<td class='creator'>".$formatter->replace($creator)."</td>";
            echo "<td class='overseer'>".$formatter->replace($overseer)."</td>";
            echo "<td class='actions'>";

            if($canEdit) {
                echo "<a title='Edit' class='actionEdit' onclick='editTask(); return false;'></a>";
                echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?action=delete&id=".$id."'></a>";
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
        $stmt = $c->prepare("SELECT project from ".$t);
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
        $stmt = $c->prepare("SELECT list FROM ".$t." WHERE project = ?");
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
            $from .= "SELECT title, created FROM ".$connect->prefix."_".$project."_".$lists[$i];
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
                $from .= "SELECT title, EXTRACT(YEAR FROM finished) AS year, EXTRACT(MONTH FROM finished) AS month FROM ".$connect->prefix."_".$project."_".$lists[$i]." WHERE taskstatus = 1";
            }
            $stmt = $c->prepare("SELECT COUNT(*) FROM (".$from.") AS a WHERE year = ".date("Y")." AND month = ".$month);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return ($result) ? $result : 0;
        }
        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT title, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month FROM ".$connect->prefix."_".$project."_".$lists[$i];
        }
        $stmt = $c->prepare("SELECT COUNT(*) FROM (".$from.") AS a WHERE year = ".date("Y")." AND month = ".$month);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return ($result) ? $result : 0;
    }
}
?>