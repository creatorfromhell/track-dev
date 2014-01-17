<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 4:20 PM
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
        $stmt = $c->prepare("INSERT INTO ".$t." (id, project, list, name, color) VALUES ('', ?, ?, ?, ?)");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->bindParam(3, $name);
        $stmt->bindParam(4, $color);
        $stmt->execute();
    }

    //delete label
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit label
    public static function edit($id, $project, $list, $name, $color) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE ".$t." SET project = ?, list = ?, name = ?, color = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->bindParam(3, $name);
        $stmt->bindParam(4, $color);
        $stmt->bindParam(5, $id);
        $stmt->execute();
    }

    //change color
    public static function changeColor($id, $color) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE ".$t." SET color = ? WHERE id = ?");
        $stmt->bindParam(1, $color);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //rename label
    public static function rename($id, $name) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }
}
?>