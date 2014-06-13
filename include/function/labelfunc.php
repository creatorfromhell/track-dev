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
require_once("include/connect.php");
class LabelFunc {

    //add label
    public static function add($project, $list, $name, $textcolor, $backgroundcolor) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, project, list, labelname, textcolor, backgroundcolor) VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->bindParam(3, $name);
        $stmt->bindParam(4, $textcolor);
        $stmt->bindParam(5, $backgroundcolor);
        $stmt->execute();
    }

    //delete label
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit label
    public static function edit($id, $project, $list, $name, $textcolor, $backgroundcolor) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE `".$t."` SET project = ?, list = ?, labelname = ?, textcolor = ?, backgroundcolor = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $list);
        $stmt->bindParam(3, $name);
        $stmt->bindParam(4, $textcolor);
        $stmt->bindParam(5, $backgroundcolor);
        $stmt->bindParam(6, $id);
        $stmt->execute();
    }

    //change color
    public static function changeColor($id, $textcolor, $backgroundcolor) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE `".$t."` SET textcolor = ?, backgroundcolor = ? WHERE id = ?");
        $stmt->bindParam(1, $textcolor);
        $stmt->bindParam(2, $backgroundcolor);
        $stmt->bindParam(3, $id);
        $stmt->execute();
    }

    //rename label
    public static function rename($id, $name) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_labels";
        $stmt = $c->prepare("UPDATE `".$t."` SET label = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    public static function printEditForm($id) {
        //TODO: print edit form
    }
}
?>