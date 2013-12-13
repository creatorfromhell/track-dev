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
class ListFunc {

    //add list
    public static function add($name, $project, $creator, $created, $gview, $gedit, $rview, $redit) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("INSERT INTO $t VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $project, $creator, $created, $gview, $gedit, $rview, $redit);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete list
    public static function delete($id) {

    }

    //edit list
    public static function edit($id, $name, $project, $creator, $created, $gview, $gedit, $rview, $redit) {

    }

    //change list project
    public static function changeProject($id, $project) {

    }

    //make list private
    public static function makePrivate($id) {

    }

    //make list public
    public static function makePublic($id) {

    }

    //rename list
    public static function rename($id, $name) {

    }
}
?>