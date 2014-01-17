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
class ListFunc {

    //add list
    public static function add($name, $project, $public, $creator, $created, $guestview, $guestedit, $rankview, $rankedit) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, name, project, public, creator, created, guestview, guestedit, rankview, rankedit) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $public);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $guestview);
        $stmt->bindParam(7, $guestedit);
        $stmt->bindParam(8, $rankview);
        $stmt->bindParam(9, $rankedit);
        $stmt->execute();
    }

    //delete list
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit list
    public static function edit($id, $name, $project, $public, $creator, $created, $guestview, $guestedit, $rankview, $rankedit) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ?, project = ?, public = ?, creator = ?, created = ?, guestview = ?, guestedit = ?, rankview = ?, rankedit = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $public);
        $stmt->bindParam(4, $creator);
        $stmt->bindParam(5, $created);
        $stmt->bindParam(6, $guestview);
        $stmt->bindParam(7, $guestedit);
        $stmt->bindParam(8, $rankview);
        $stmt->bindParam(9, $rankedit);
        $stmt->bindParam(10, $id);
        $stmt->execute();
    }

    //change list project
    public static function changeProject($id, $project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE ".$t." SET project = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //make list private
    public static function makePrivate($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE ".$t." SET public = 0 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //make list public
    public static function makePublic($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE ".$t." SET public = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //rename list
    public static function rename($id, $name) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_lists";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }
}
?>