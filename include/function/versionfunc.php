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
class VersionFunc {

    //add version
    public static function add($name, $project, $due, $release) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, name, project, due, release) VALUES ('', ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $due);
        $stmt->bindParam(4, $release);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete version
    public static function delete($id) {

    }

    //edit version
    public static function edit($id, $name, $project, $due, $release) {

    }

    //change due date
    public static function changeDue($id, $due) {

    }

    //change project
    public static function changeProject($id, $project) {

    }

    //change release date
    public static function changeRelease($id, $release) {

    }

    //rename version
    public static function rename($id, $name) {

    }
}
?>