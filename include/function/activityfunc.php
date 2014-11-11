<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/11/14 at 5:20 PM
 * Last Modified by Daniel Vidmar.
 */
class ActivityFunc {

    //log activity
    public static function log($username, $project, $list, $type, $parameters, $archived, $logged) {
		global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, username, project, list, activity_type, activity_parameters, archived, logged) VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $list);
        $stmt->bindParam(4, $type);
        $stmt->bindParam(5, $parameters);
        $stmt->bindParam(6, $archived);
        $stmt->bindParam(7, $logged);
        $stmt->execute();
    }

    public static function parseType($id, $language) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("SELECT activity_type FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //Example Type: user:login
        $type = explode(":", $result['activity_type']);

        $value = $language->xpath("site/activities/".$type[0]."/".$type[1])[0];
        return (string)($value);
    }

    //get readable activity
    public static function getReadableActivity($id, $language) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("SELECT username, project, list, activity_parameters, archived, logged FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $replace = array("%user", "%project", "%list", "%logged");
        $replacements = array($result['username'], $result['project'], $result['list'], $result['logged']);
        $description = self::parseType($id, $language);

        if(trim($result['activity_parameters']) != '') {
            $parameters = explode(',', $result['activity_parameters']);

            foreach($parameters as &$param) {
                $pars = explode(':', $param);
                $description = str_ireplace("%".$pars[0], $pars[1], $description);
            }
        }

        $activity = str_ireplace($replace, $replacements, $description);
        return $activity;
    }

    //archive log
    public static function archive($id) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET archived = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //unarchive log
    public static function unarchive($id) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET archived = 0 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public static function delete($id) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //clean logs
    public static function clean() {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE archived = 0 AND logged < DATE_SUB(CURDATE(), INTERVAL 5 DAY)");
        $stmt->execute();
    }
}
?>