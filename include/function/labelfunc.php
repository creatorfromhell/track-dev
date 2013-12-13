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
class LabelFunc {

    //add label
    public static function add($project, $list, $name, $color) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("INSERT INTO $t VALUES ('', ?, ?, ?, ?)");
        $stmt->bind_param("ssss", $project, $list, $name, $color);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete label
    public static function delete($id) {

    }

    //edit label
    public static function edit($id, $name, $color) {

    }

    //change color
    public static function changeColor($id, $color) {

    }

    //rename label
    public static function rename($id, $name) {

    }
}
?>