<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Alpha 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("../connect.php");
class GroupFunc {

    //add group function
    public static function add($name, $permission, $default, $admin) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, name, permission, default, admin) VALUES ('', ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $permission);
        $stmt->bindParam(3, $default);
        $stmt->bindParam(4, $admin);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //edit group function
    public static function edit($id, $name, $permission, $default, $admin) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ?, permission = ?, default = ?, admin = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $permission);
        $stmt->bindParam(3, $default);
        $stmt->bindParam(4, $admin);
        $stmt->bindParam(5, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete group function
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //change group perm
    public static function changePermission($id, $permission) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE ".$t." SET permission = ? WHERE id = ?");
        $stmt->bindParam(1, $permission);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //get default
    public static function getDefault() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
    }

    //make admin
    public static function makeAdmin($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE ".$t." SET admin = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //make default
    public static function makeDefault($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";

        //Get the current default group and remove its default status
        $current = self::getDefault();
        $stmt = $c->prepare("UPDATE ".$t." SET default = 0 WHERE name = ?");
        $stmt->bindParam(1, $current);
        $stmt->execute();

        //Set the new group to the default group
        $stmt = $c->prepare("UPDATE ".$t." SET default = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //rename group
    public static function rename($id, $name) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }
}
?>