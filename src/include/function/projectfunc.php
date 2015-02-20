<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */
require_once("include/function/ListFunc.php");

/**
 * Class ProjectFunc
 */
class ProjectFunc {

    //add project
    /**
     * @param $project
     * @param $preset
     * @param $main
     * @param $creator
     * @param $created
     * @param $overseer
     * @param $public
     */
    public static function addProject($project, $preset, $main, $creator, $created, $overseer, $public) {
		global $prefix, $pdo;
		$permissions = 'view:none,edit:none';
        $t = $prefix."_projects";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, project, preset, main, creator, created, overseer, project_permissions, public) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($project, $preset, $main, $creator, $created, $overseer, $permissions, $public));
    }

    /**
     * @param $id
     */
    public static function remove($id) {
        $project = self::getName($id);
        $lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");
        foreach($lists as &$list) {
            $listid = ListFunc::getID($project, $list);
            ListFunc::remove($listid);
        }
        self::deleteProject($id);
    }

    //delete project
    /**
     * @param $id
     */
    public static function deleteProject($id) {
        global $prefix, $pdo;
        $t = $prefix."_projects";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //edit project
    /**
     * @param $id
     * @param $project
     * @param $preset
     * @param $main
     * @param $overseer
     * @param $public
     */
    public static function editProject($id, $project, $preset, $main, $overseer, $public) {
        global $prefix, $pdo;
        $t = $prefix."_projects";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET project = ?, preset = ?, main = ?, overseer = ?, public = ? WHERE id = ?");
        $stmt->execute(array($project, $preset, $main, $overseer, $public, $id));
    }

    //get project id
    /**
     * @param $project
     * @return mixed
     */
    public static function getID($project) {
        return value("projects", "id", " WHERE project = '".cleanInput($project)."'");
    }

    //change main list id
    /**
     * @param $id
     * @param $main
     */
    public static function changeMain($id, $main) {
        setValue("projects", "main", $main, " WHERE id = '".cleanInput($id)."'");
    }

    //get main list id
    /**
     * @param $id
     * @return mixed
     */
    public static function getMain($id) {
        return value("projects", "main", " WHERE id = '".cleanInput($id)."'");
    }

    /**
     * @param $project
     * @return mixed
     */
    public static function getMainList($project) {
        $id = self::getID($project);
        $listID = self::getMain($id);
        return value("lists", "lists", " WHERE id = '".cleanInput($listID)."'");
    }

    //get overseer
    /**
     * @param $project
     * @return mixed
     */
    public static function getOverseer($project) {
        return value("projects", "overseer", " WHERE project = '".cleanInput($project)."'");
    }

    //change overseer
    /**
     * @param $id
     * @param $overseer
     */
    public static function changeOverseer($id, $overseer) {
        setValue("projects", "overseer", $overseer, " WHERE id = '".cleanInput($id)."'");
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getName($id) {
        return value("projects", "project", " WHERE id = '".cleanInput($id)."'");
    }

    //get preset project
    /**
     * @return mixed
     */
    public static function getPreset() {
        return value("projects", "project", " WHERE preset = 1");
    }

    //make preset project
    /**
     * @param $id
     */
    public static function makePreset($id) {
        self::removePreset();
        setValue("projects", "preset", "1", " WHERE id = '".cleanInput($id)."'");
    }

    /**
     *
     */
    public static function removePreset() {
        $id = self::getID(self::getPreset());
        setValue("projects", "preset", "0", " WHERE id = '".cleanInput($id)."'");
    }

    //make project private
    /**
     * @param $id
     */
    public static function makePrivate($id) {
        setValue("projects", "public", "0", " WHERE id = '".cleanInput($id)."'");
    }

    //make project public
    /**
     * @param $id
     */
    public static function makePublic($id) {
        setValue("projects", "public", "1", " WHERE id = '".cleanInput($id)."'");
    }

    /**
     * @param $id
     * @return array
     */
    public static function projectDetails($id) {
        $return = array();
        global $prefix, $pdo;
        $t = $prefix."_projects";
        $stmt = $pdo->prepare("SELECT project, preset, main, creator, created, overseer, project_permissions, public FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $return['name'] = $result['project'];
        $return['preset'] = $result['preset'];
        $return['main'] = $result['main'];
        $return['creator'] = $result['creator'];
        $return['created'] = $result['created'];
        $return['overseer'] = $result['overseer'];
		$return['permissions'] = $result['project_permissions'];
        $return['public'] = $result['public'];

        return $return;
    }

    //reproject project
    /**
     * @param $id
     * @param $oldname
     * @param $project
     */
    public static function renameProject($id, $oldname, $project) {
        $lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");
        foreach($lists as &$list) {
            ListFunc::changeProject(ListFunc::getID($oldname, $list), $project);
        }
        setValue("projects", "project", $project, " WHERE id = '".cleanInput($id)."'");
    }

    /**
     * @param $project
     * @return array
     */
    public static function latestTasks($project) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");
        $from = "";

        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT title, created FROM `".$prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $pdo->prepare("SELECT title FROM (".$from.") AS a ORDER BY created DESC LIMIT 7");
        $stmt->execute();
        $result = $stmt->fetchAll();

        $tasks = array();
        for($i = 0; $i < count($result); $i++) {
            $task = $result[$i];
            $tasks[$i] = $task[0];
        }
        return $tasks;
    }

    /**
     * @param $project
     * @param $months
     * @param $completed
     * @return string
     */
    public static function getTasksChartData($project, $months, $completed) {
        $data = "";
        if($months) {
            for ($i = -6; $i <= 0; $i++){
                if( $i > -6) { $data .= ','; }
                $data .= '"'.date('M', strtotime("$i month")).'"';
            }
        } else {
            for ($i = -6; $i <= 0; $i++){
                if( $i > -6) { $data .= ","; }
                $data .= self::getTaskCountByMonth($project, date('m', strtotime("$i month")), $completed);
            }
        }
        return $data;
    }

    /**
     * @param string $month
     */
    public static function getTaskCountByMonth($project, $month, $completed) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");

        $from = "";
        $date = ($completed) ? "finished" : "created";
        $status = ($completed) ? " WHERE task_status = 1" : "";
        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT title, EXTRACT(YEAR FROM ".$date.") AS year, EXTRACT(MONTH FROM ".$date.") AS month FROM `".$prefix."_".$project."_".$lists[$i]."`".$status;
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM (".$from.") AS a WHERE year = ".date("Y")." AND month = ".$month);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return ($result) ? $result : 0;
    }

    /**
     * @param $project
     * @param $users
     * @param $completed
     * @return string
     */
    public static function getAssignedUsersChartData($project, $users, $completed) {
        $dataArray = self::getTopAssignedUsers($project);
        $userArray = $dataArray[0];
        $totalArray = $dataArray[1];
        $completedArray = $dataArray[2];

        if($users) {
            return implode(",", $userArray);
        } else {
            if($completed) {
                return implode(",", $completedArray);
            } else {
                return implode(",", $totalArray);
            }
        }
    }

    /**
     * @param $project
     * @return array
     */
    public static function getTopAssignedUsers($project) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");
        $users = array();
        $totals = array();
        $completed = array();

        $from = "";
        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT id, assignee FROM `".$prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $pdo->prepare("SELECT assignee, Count(a.id) AS total FROM(".$from.") AS a GROUP BY assignee ORDER BY total DESC LIMIT 5");
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
                $from .= "SELECT id FROM `".$prefix."_".$project."_".$lists[$i2]."` WHERE assignee = '".$users[$i]."' AND task_status = 1";
            }
            $stmt = $pdo->prepare("SELECT Count(a.id) FROM(".$from.") AS a");
            $stmt->execute();
            $result = $stmt->fetchColumn();
            $completed[$i] = ($result) ? $result : 0;
        }
        return array($users, $totals, $completed);
    }

    /**
     * @param $project
     * @param $year
     * @param $month
     * @param $day
     * @return bool
     */
    public static function hasEvent($project, $year, $month, $day) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM (SELECT id, project, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month, EXTRACT(DAY FROM created) AS day FROM `".$prefix."_lists`) AS a WHERE project = ".$project." AND year = ".$year." AND month = ".$month." AND day = ".$day);
        $stmt->execute();
        if($stmt->fetchColumn()) {
            return true;
        }

        $from = "";
        for($i = 0; $i < count($lists); $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT id, EXTRACT(YEAR FROM due) AS year, EXTRACT(MONTH FROM due) AS month, EXTRACT(DAY FROM due) AS day FROM `".$prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM (".$from.") AS a WHERE year = ".$year." AND month = ".$month." AND day = ".$day);
        $stmt->execute();
        if($stmt->fetchColumn()) {
            return true;
        }
        return false;
    }

    /**
     * @param $project
     * @param $year
     * @param $month
     * @param $day
     * @return string
     */
    public static function getEvents($project, $year, $month, $day) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = '".cleanInput($project)."'");
        $toReturn = "";
        if(self::hasEvent($project, $year, $month, $day)) {
            $toReturn .= "<ul>";

            $stmt = $pdo->prepare("SELECT name, author FROM (SELECT id, name, author, project, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month, EXTRACT(DAY FROM created) AS day FROM `".$prefix."_lists`) AS a WHERE project = ".$project." AND year = ".$year." AND month = ".$month." AND day = ".$day);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $toReturn .= '<li>List: <a href="list.php?p='.$project.'&list='.$row['name'].'">'.$row['name'].'</a>, was created by '.$row['author'].'.</li>';
            }

            $from = "";
            for($i = 0; $i < count($lists); $i++) {
                if($i > 0) { $from .= " UNION ALL "; }
                $from .= "SELECT id, title, author, EXTRACT(YEAR FROM due) AS year, EXTRACT(MONTH FROM due) AS month, EXTRACT(DAY FROM due) AS day FROM `".$prefix."_".$project."_".$lists[$i]."`";
            }
            $stmt = $pdo->prepare("SELECT id, title, author FROM (".$from.") AS a WHERE year = ".$year." AND month = ".$month." AND day = ".$day);
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

    /**
     * @param $year
     * @param $month
     * @param $day
     * @return int
     */
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

    /**
     * @param $id
     * @return string
     */
    public static function printEditForm($id) {
        $details = self::projectDetails($id);
        $out = '';
        $out .= '<h3>Edit Project</h3>';
        $out .= '<div id="holder">';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input id="id" name="id" type="hidden" value="'.$id.'">';
        $out .= '<input id="name" name="name" type="text" placeholder="Name" value="'.$details['name'].'">';
        $out .= '<label for="public">Public:</label>';
        $out .= '<select name="public" id="public">';
        $out .= '<option value="0"'.(($details['public'] == 0) ? ' selected' : '').'>No</option>';
        $out .= '<option value="1"'.(($details['public'] == 1) ? ' selected' : '').'>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="mainlist">Main List:</label>';
        $out .= '<select name="mainlist" id="mainlist">';
        $lists = values("lists", "list", " WHERE project = '".cleanInput($details['name'])."'");
        foreach($lists as &$list) {
            $listID = ListFunc::getID($details['name'], $list);
            $out .= '<option value="'.$listID.'"'.(($listID == $details['main']) ? ' selected' : '').'>'.$list.'</option>';
        }
        $out .= '</select><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button id="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_2">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="mainproject">Main:</label>';
        $out .= '<select name="mainproject" id="mainproject">';
        $out .= '<option value="0"'.(($details['main'] == 0) ? ' selected' : '').'>No</option>';
        $out .= '<option value="1"'.(($details['main'] == 1) ? ' selected' : '').'>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="overseer">Overseer:</label>';
        $out .= '<select name="overseer" id="overseer">';
        $out .= '<option value="none"'.(($details['overseer'] == 'none') ? ' selected' : '').'>None</option>';
        $out .= toOptions(values("users", "user_name"), $details['overseer']);
        $out .= '</select>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button id="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
        $out .= '<input type="submit" id="submit" name="edit-project" value="Submit">';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '</div>';

        return $out;
    }
}