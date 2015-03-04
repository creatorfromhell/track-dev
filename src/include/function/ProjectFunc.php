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
    public static function add_project($project, $preset, $main, $creator, $created, $overseer, $public) {
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
        $project = self::get_name($id);
        $lists = values("lists", "list", " WHERE project = ?", array($project));
        foreach($lists as &$list) {
            $list_id = ListFunc::get_id($project, $list);
            ListFunc::remove($list_id);
        }
        self::delete_project($id);
    }

    //delete project
    /**
     * @param $id
     */
    public static function delete_project($id) {
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
    public static function edit_project($id, $project, $preset, $main, $overseer, $public) {
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
    public static function get_id($project) {
        return value("projects", "id", " WHERE project = ?", array($project));
    }

    //change main list id
    /**
     * @param $id
     * @param $main
     */
    public static function change_main($id, $main) {
        set_value("projects", "main", $main, " WHERE id = ?", array($id));
    }

    //get main list id
    /**
     * @param $id
     * @return mixed
     */
    public static function get_main($id) {
        return value("projects", "main", " WHERE id = ?", array($id));
    }

    /**
     * @param $project
     * @return mixed
     */
    public static function get_main_list($project) {
        $id = self::get_id($project);
        $listID = self::get_main($id);
        return value("lists", "lists", " WHERE id = ?", array($listID));
    }

    //get overseer
    /**
     * @param $project
     * @return mixed
     */
    public static function get_overseer($project) {
        return value("projects", "overseer", " WHERE project = ?", array($project));
    }

    //change overseer
    /**
     * @param $id
     * @param $overseer
     */
    public static function change_overseer($id, $overseer) {
        set_value("projects", "overseer", $overseer, " WHERE id = ?", array($id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function get_name($id) {
        return value("projects", "project", " WHERE id = ?", array($id));
    }

    //get preset project
    /**
     * @return mixed
     */
    public static function get_preset() {
        return value("projects", "project", " WHERE preset = 1");
    }

    //make preset project
    /**
     * @param $id
     */
    public static function make_preset($id) {
        self::remove_preset();
        set_value("projects", "preset", "1", " WHERE id = ?", array($id));
    }

    /**
     *
     */
    public static function remove_preset() {
        $id = self::get_id(self::get_preset());
        set_value("projects", "preset", "0", " WHERE id = ?", array($id));
    }

    //make project private
    /**
     * @param $id
     */
    public static function make_private($id) {
        set_value("projects", "public", "0", " WHERE id = ?", array($id));
    }

    //make project public
    /**
     * @param $id
     */
    public static function make_public($id) {
        set_value("projects", "public", "1", " WHERE id = ?", array($id));
    }

    /**
     * @param $id
     * @return array
     */
    public static function project_details($id) {
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
    public static function rename_project($id, $oldname, $project) {
        $lists = values("lists", "list", " WHERE project = ?", array($project));
        foreach($lists as &$list) {
            ListFunc::change_project(ListFunc::get_id($oldname, $list), $project);
        }
        set_value("projects", "project", $project, " WHERE id = ?", array($id));
    }

    /**
     * @param $project
     * @return array
     */
    public static function latest_tasks($project) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = ?", array($project));
        $from = "";

        $list_count = count($lists);
        for($i = 0; $i < $list_count; $i++) {
            if($i > 0) { $from .= " UNION ALL "; }
            $from .= "SELECT title, created FROM `".$prefix."_".$project."_".$lists[$i]."`";
        }
        $stmt = $pdo->prepare("SELECT title FROM (".$from.") AS a ORDER BY created DESC LIMIT 7");
        $stmt->execute();
        $result = $stmt->fetchAll();

        $tasks = array();
        $result_count = count($result);
        for($i = 0; $i < $result_count; $i++) {
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
    public static function get_tasks_chart_data($project, $months, $completed) {
        $data = "";
        for ($i = -6; $i <= 0; $i++){
            if( $i > -6) { $data .= ','; }
            $data .= '"'.date('M', strtotime("$i month")).'"';
            if($months) {
                $data .= '"'.date('M', strtotime("$i month")).'"';
            } else {
                $data .= self::get_task_count_by_month($project, date('m', strtotime("$i month")), $completed);
            }
        }
        return $data;
    }

    /**
     * @param string $project
     * @param string $month
     * @param bool $completed
     * @return int
     */
    public static function get_task_count_by_month($project, $month, $completed) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = ?", array($project));

        $from = "";
        $date = ($completed) ? "finished" : "created";
        $status = ($completed) ? " WHERE task_status = 1" : "";
        $list_count = count($lists);
        for($i = 0; $i < $list_count; $i++) {
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
    public static function get_assigned_users_chart_data($project, $users, $completed) {
        $dataArray = self::get_top_assigned_users($project);
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
    public static function get_top_assigned_users($project) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = ?", array($project));
        $users = array();
        $totals = array();
        $completed = array();

        $from = "";
        $list_count = count($lists);
        for($i = 0; $i < $list_count; $i++) {
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

        $user_count = count($users);
        for($i = 0; $i < $user_count; $i++) {
            $from = "";
            $list_count = count($lists);
            for($i2 = 0; $i2 < $list_count; $i2++) {
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
    public static function has_event($project, $year, $month, $day) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = ?", array($project));

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM (SELECT id, project, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month, EXTRACT(DAY FROM created) AS day FROM `".$prefix."_lists`) AS a WHERE project = ".$project." AND year = ".$year." AND month = ".$month." AND day = ".$day);
        $stmt->execute();
        if($stmt->fetchColumn()) {
            return true;
        }

        $from = "";
        $list_count = count($lists);
        for($i = 0; $i < $list_count; $i++) {
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
    public static function get_events($project, $year, $month, $day) {
        global $prefix, $pdo;
        $lists = values("lists", "list", " WHERE project = ?", array($project));
        $toReturn = "";
        if(self::has_event($project, $year, $month, $day)) {
            $toReturn .= "<ul>";

            $stmt = $pdo->prepare("SELECT name, author FROM (SELECT id, name, author, project, EXTRACT(YEAR FROM created) AS year, EXTRACT(MONTH FROM created) AS month, EXTRACT(DAY FROM created) AS day FROM `".$prefix."_lists`) AS a WHERE project = ".$project." AND year = ".$year." AND month = ".$month." AND day = ".$day);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $toReturn .= '<li>List: <a href="list.php?p='.$project.'&list='.$row['name'].'">'.$row['name'].'</a>, was created by '.$row['author'].'.</li>';
            }

            $from = "";
            $list_count = count($lists);
            for($i = 0; $i < $list_count; $i++) {
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
    public static function get_correct_date($year, $month, $day) {
        $newYear = $year;
        $newMonth = $month;
        $newDay = $day;
        $newTime = mktime(0, 0, 0, $newMonth, $newDay, $newYear);

        if($newDay < 1) {
            $newMonth--;
            $newDay = date('t', mktime(0, 0, 0, $newMonth, 1, $newYear));
        } else if($newDay > date('t', $newTime)) {
            $newMonth++;
            $newDay = 1;
        }

        if($newMonth < 1) {
            $newMonth = 12;
            $newYear--;
        } else if($newMonth > 12) {
            $newMonth = 1;
            $newYear++;
        }
        $newTime = mktime(0, 0, 0, $newMonth, $newDay, $newYear);
        return $newTime;
    }
}