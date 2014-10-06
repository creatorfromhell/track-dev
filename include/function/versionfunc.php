<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */
class VersionFunc {

    /*
     * Version Functions
     */

    //add version
    public static function add($version, $project, $due, $released, $type) {
		global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, version_name, project, due, released, version_type) VALUES ('', ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $due);
        $stmt->bindParam(4, $released);
        $stmt->bindParam(5, $type);
        $stmt->execute();
    }

    //delete version
    public static function delete($id) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit version
    public static function edit($id, $version, $project, $due, $released, $type) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_name = ?, project = ?, due = ?, released = ?, version_type = ? WHERE id = ?");
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
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET due = ? WHERE id = ?");
        $stmt->bindParam(1, $due);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change project
    public static function changeProject($id, $project) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET project = ? WHERE id = ?");
        $stmt->bindParam(1, $project);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change release date
    public static function changeRelease($id, $release) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET release = ? WHERE id = ?");
        $stmt->bindParam(1, $release);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //change version type
    public static function changeType($id, $type) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_type = ? WHERE id = ?");
        $stmt->bindParam(1, $type);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //reversion version
    public static function rename($id, $version) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_name = ? WHERE id = ?");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    public static function printEditForm($id) {
        //TODO: print edit form
    }


    /*
     * Version Type Functions
     */

    //add version type
    public static function addType($versiontype, $description) {
        global $prefix, $pdo;
        $t = $prefix."_versions_types";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, version_type, description) VALUES ('', ?, ?)");
        $stmt->bindParam(1, $versiontype);
        $stmt->bindParam(2, $description);
        $stmt->execute();
    }

    //edit version type
    public static function editType($id, $versiontype, $description) {
        global $prefix, $pdo;
        $t = $prefix."_versions_types";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_type = ?, description = ? WHERE id = ?");
        $stmt->bindParam(1, $versiontype);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $id);
        $stmt->execute();
    }

    //delete version type
    public static function deleteType($id) {
        global $prefix, $pdo;
        $t = $prefix."_versions_types";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public static function printTypeEditForm($id) {
        //TODO: print edit form
    }
}
?>