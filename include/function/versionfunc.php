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
class VersionFunc {

    /*
     * Version Functions
     */

    //add version
    public static function add($name, $project, $due, $release, $type) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, name, project, due, release, type) VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $due);
        $stmt->bindParam(4, $release);
        $stmt->bindParam(5, $type);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete version
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //edit version
    public static function edit($id, $name, $project, $due, $release, $type) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ?, project = ?, due = ?, release = ?, type = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $due);
        $stmt->bindParam(4, $release);
        $stmt->bindParam(5, $type);
        $stmt->bindParam(6, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //change due date
    public static function changeDue($id, $due) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE ".$t." SET due = ? WHERE id = ?");
        $stmt->bindParam(1, $due);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //change project
    public static function changeProject($id, $project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE ".$t." SET project = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //change release date
    public static function changeRelease($id, $release) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE ".$t." SET release = ? WHERE id = ?");
        $stmt->bindParam(1, $release);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //change version type
    public static function changeType($id, $type) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE ".$t." SET type = ? WHERE id = ?");
        $stmt->bindParam(1, $type);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //rename version
    public static function rename($id, $name) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }


    /*
     * Version Type Functions
     */

    //add version type
    public static function addType($name, $description) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions_types";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, name, description) VALUES ('', ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $description);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //edit version type
    public static function editType($id, $name, $description) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions_types";
        $stmt = $c->prepare("UPDATE ".$t." SET name = ?, description = ? WHERE id = ?");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }

    //delete version type
    public static function deleteType($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions_types";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $stmt->close();
        $c->close();
    }
}
?>