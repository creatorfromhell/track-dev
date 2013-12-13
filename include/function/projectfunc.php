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
class ProjectFunc {

    //add project
    public static function add($name, $default, $main, $creator, $created, $overseer, $public) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("INSERT INTO $t VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $default, $main, $creator, $created, $overseer, $public);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete project
    public static function delete($id) {

    }

    //edit project
    public static function edit($id, $name, $default, $main, $creator, $created, $overseer, $public) {

    }

    //change main list
    public static function changeMain($id, $list) {

    }

    //change overseer
    public static function changeOverseer($id, $overseer) {

    }

    //get default project
    public static function getDefault() {

    }

    //make default project
    public static function makeDefault($id) {

    }

    //make project private
    public static function makePrivate($id) {

    }

    //make project public
    public static function makePublic($id) {

    }

    //rename project
    public static function rename($id, $name) {

    }
}
?>