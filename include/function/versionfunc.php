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
require_once("include/connect.php");
class VersionFunc {

    /*
     * Version Functions
     */

    //add version
    public static function add($version, $project, $due, $released, $type) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, version, project, due, released, type) VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $due);
        $stmt->bindParam(4, $released);
        $stmt->bindParam(5, $type);
        $stmt->execute();
    }

    //delete version
    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit version
    public static function edit($id, $version, $project, $due, $released, $type) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE `".$t."` SET version = ?, project = ?, due = ?, released = ?, type = ? WHERE id = ?");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $due);
        $stmt->bindParam(4, $released);
        $stmt->bindParam(5, $type);
        $stmt->bindParam(6, $id);
        $stmt->execute();
    }

    //change due date
    public static function changeDue($id, $due) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE `".$t."` SET due = ? WHERE id = ?");
        $stmt->bindParam(1, $due);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change project
    public static function changeProject($id, $project) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE `".$t."` SET project = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change release date
    public static function changeRelease($id, $release) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE `".$t."` SET release = ? WHERE id = ?");
        $stmt->bindParam(1, $release);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change version type
    public static function changeType($id, $type) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE `".$t."` SET type = ? WHERE id = ?");
        $stmt->bindParam(1, $type);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //reversion version
    public static function rename($id, $version) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions";
        $stmt = $c->prepare("UPDATE `".$t."` SET version = ? WHERE id = ?");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }


    /*
     * Version Type Functions
     */

    //add version type
    public static function addType($versiontype, $description) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions_types";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, versiontype, description) VALUES ('', ?, ?)");
        $stmt->bindParam(1, $versiontype);
        $stmt->bindParam(2, $description);
        $stmt->execute();
    }

    //edit version type
    public static function editType($id, $versiontype, $description) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions_types";
        $stmt = $c->prepare("UPDATE `".$t."` SET versiontype = ?, description = ? WHERE id = ?");
        $stmt->bindParam(1, $versiontype);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $id);
        $stmt->execute();
    }

    //delete version type
    public static function deleteType($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_versions_types";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }
}
?>