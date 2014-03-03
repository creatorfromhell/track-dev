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
class GroupFunc {

    //add group function
    public static function add($name, $permission, $preset, $admin) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, name, permission, preset, admin) VALUES ('', ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $permission);
        $stmt->bindParam(3, $preset);
        $stmt->bindParam(4, $admin);
        $stmt->execute();
    }

    //edit group function
    public static function edit($id, $name, $permission, $preset, $admin) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ?, permission = ?, preset = ?, admin = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $permission);
        $stmt->bindParam(3, $preset);
        $stmt->bindParam(4, $admin);
        $stmt->bindParam(5, $id);
        $stmt->execute();
    }

    //delete group function
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
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
    }

    //get preset
    public static function getPreset() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT name FROM ".$t." WHERE preset = 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];
    }

    //make admin
    public static function makeAdmin($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE ".$t." SET admin = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //make preset
    public static function makePreset($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";

        //Get the current preset group and remove its preset status
        $current = self::getPreset();
        $stmt = $c->prepare("UPDATE ".$t." SET preset = 0 WHERE name = ?");
        $stmt->bindParam(1, $current);
        $stmt->execute();

        //Set the new group to the preset group
        $stmt = $c->prepare("UPDATE ".$t." SET preset = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
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
    }

    //is admin
    public static function isAdmin($group) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT admin FROM ".$t." WHERE name = ?");
        $stmt->bindParam(1, $group);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin = $result['admin'];

        if($admin == 1) {
            return true;
        }
        return false;
    }
}
?>