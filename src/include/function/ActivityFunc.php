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
    /**
     * @param $username
     * @param $project
     * @param $list
     * @param $type
     * @param $parameters
     * @param $archived
     * @param $logged
     */
    public static function log($username, $project, $list, $type, $parameters, $archived, $logged) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, username, project, list, activity_type, activity_parameters, archived, logged) VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($username, $project, $list, $type, $parameters, $archived, $logged));
    }

    /**
     * @param $id
     * @param $language_manager
     * @return string
     */
    public static function parse_type($id, $language_manager, $language) {
        if(!($language_manager instanceof LanguageManager)) {
            return "Unable to parse activity type.";
        }
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("SELECT activity_type FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //Example Type: user:login
        $type = explode(":", $result['activity_type']);
        $value = $language_manager->get_value($language, "site/activities/".$type[0]."/".$type[1]);
        return (string)($value);
    }

    //get readable activity
    /**
     * @param $id
     * @param $language_manager
     * @return mixed
     */
    public static function get_readable_activity($id, $language_manager, $language) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("SELECT username, project, list, activity_parameters, archived, logged FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $replace = array("%user", "%project", "%list", "%logged");
        $replacements = array($result['username'], $result['project'], $result['list'], $result['logged']);
        $description = self::parse_type($id, $language_manager, $language);

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
    /**
     * @param $id
     */
    public static function archive($id) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET archived = 1 WHERE id = ?");
       $stmt->execute(array($id));
    }

    //unarchive log
    /**
     * @param $id
     */
    public static function unarchive($id) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET archived = 0 WHERE id = ?");
        $stmt->execute(array($id));
    }

    /**
     * @param $id
     */
    public static function delete($id) {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //clean logs
    /**
     *
     */
    public static function clean() {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE archived = 0 AND logged < DATE_SUB(CURDATE(), INTERVAL 5 DAY)");
        $stmt->execute();
    }
}