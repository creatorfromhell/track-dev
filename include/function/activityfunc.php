<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/11/14 at 5:20 PM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("include/connect.php");
class ActivityFunc {

    //log activity
    public static function log($user, $project, $list, $description, $archived, $logged) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, user, project, list, description, archived, logged) VALUES ('', ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $user);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $list);
        $stmt->bindParam(4, $description);
        $stmt->bindParam(5, $archived);
        $stmt->bindParam(6, $logged);
        $stmt->execute();
    }

    //clean logs
    public static function clean() {
        //TODO: Make function to clean old logs that are not archived
    }

    //backup logs
    public static function backup($format) {
        //TODO: Make function to backup logs to some format(XML, CSV, etc) or maybe configurable format?
    }
}
?>