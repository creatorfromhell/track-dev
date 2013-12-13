<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Alpha 1
 * Last Modified: 12/13/13 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("../connect.php");
class ActivityFunc {

    //log activity
    public static function log($user, $project, $list, $description, $logged) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("INSERT INTO $t VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user, $project, $list, $description, $logged);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //clean logs
    public static function clean() {

    }

    //backup logs
    public static function backup() {

    }
}
?>