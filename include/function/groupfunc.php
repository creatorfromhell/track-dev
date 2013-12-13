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
class GroupFunc {

    //add group function
    public static function add($name, $perm, $default, $admin) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("INSERT INTO $t VALUES ('', ?, ?, ?, ?)");
        $stmt->bind_param("siii", $name, $perm, $default, $admin);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //edit group function
    public static function edit($id, $name, $perm, $default, $admin) {

    }

    //delete group function
    public static function delete($id) {

    }

    //change group perm
    public static function changePerm($id, $perm) {

    }

    //get default
    public static function getDefault() {

    }

    //make admin
    public static function makeAdmin($id) {

    }

    //make default
    public static function makeDefault($id) {

    }

    //rename group
    public static function rename($id, $name) {

    }
}
?>