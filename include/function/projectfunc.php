<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
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
        $stmt = $c->prepare("INSERT INTO ".$t." (id, name, default, main, creator, created, overseer, public) VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $default);
        $stmt->bindParam(3, $main);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $overseer);
        $stmt->bindParam(7, $public);
        $stmt->execute();
    }

    //delete project
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit project
    public static function edit($id, $name, $default, $main, $creator, $created, $overseer, $public) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ?, default = ?, main = ?, creator = ?, created = ?, overseer = ?, public = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $default);
        $stmt->bindParam(3, $main);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $overseer);
        $stmt->bindParam(7, $public);
        $stmt->bindParam(8, $id);
        $stmt->execute();
    }

    //change main list
    public static function changeMain($id, $main) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET main = ? WHERE id = ?");
        $stmt->bindParam(1, $main);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change overseer
    public static function changeOverseer($id, $overseer) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET overseer = ? WHERE id = ?");
        $stmt->bindParam(1, $overseer);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //get default project
    public static function getDefault() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
    }

    //make default project
    public static function makeDefault($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET default = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //make project private
    public static function makePrivate($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET public = 0 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //make project public
    public static function makePublic($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET public = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //rename project
    public static function rename($id, $name) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_projects";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }
}
?>