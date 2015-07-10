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
    /**
     * @param $version
     * @param $project
     * @param $status
     * @param $due
     * @param $released
     * @param $type
     */
    public static function add_version($version, $project, $status, $due, $released, $type) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, version_name, project, version_status, due, released, version_type) VALUES ('', ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($version, $project, $status, $due, $released, $type));
    }

    public static function version_id($project, $version_name) {
        global $prefix;
        $t = $prefix."_versions";
        $id = value($t, "id", "WHERE project = ? AND version_name = ?", array($project, $version_name));
        return $id;
    }

    //delete version
    /**
     * @param $id
     */
    public static function delete_version($id) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //edit version
    /**
     * @param $id
     * @param $version
     * @param $project
     * @param $status
     * @param $due
     * @param $released
     * @param $type
     */
    public static function edit_version($id, $version, $project, $status, $due, $released, $type) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_name = ?, project = ?, version_status = ?, due = ?, released = ?, version_type = ? WHERE id = ?");
        $stmt->execute(array($version, $project, $status, $due, $released, $type, $id));
    }

    //change due date
    /**
     * @param $id
     * @param $due
     */
    public static function change_due($id, $due) {
        set_value("versions", "due", $due, " WHERE id = ?", array($id));
    }

    //change project
    /**
     * @param $id
     * @param $project
     */
    public static function change_project($id, $project) {
        set_value("versions", "project", $project, " WHERE id = ?", array($id));
    }

    //change release date
    /**
     * @param $id
     * @param $release
     */
    public static function change_release($id, $release) {
        set_value("versions", "release", $release, " WHERE id = ?", array($id));
    }

    //change version type
    /**
     * @param $id
     * @param $type
     */
    public static function change_type($id, $type) {
        set_value("versions", "version_type", $type, " WHERE id = ?", array($id));
    }

    public static function change_file($id, $file) {
        set_value("versions", "version_download", $file, " WHERE id = ?", array($id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function get_project($id) {
        return value("versions", "project", " WHERE id = ?", array($id));
    }

    //reversion version
    /**
     * @param $id
     * @param $version
     */
    public static function rename_version($id, $version) {
        set_value("versions", "version_name", $version, " WHERE id = ?", array($id));
    }

    /**
     * @param $id
     * @return array
     */
    public static function version_details($id) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("SELECT version_name, project, version_status, due, released, version_type FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $return = array();
        $return['name'] = $result['version_name'];
        $return['project'] = $result['project'];
        $return['status'] = $result['version_status'];
        $return['due'] = $result['due'];
        $return['released'] = $result['released'];
        $return['type'] = $result['version_type'];
        return $return;
    }

    /*
     * Version Type Functions
     */

    //add version type
    /**
     * @param $type
     * @param $description
     * @param $stable
     */
    public static function add_type($type, $description, $stable) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, version_type, description, version_stability) VALUES ('', ?, ?, ?)");
        $stmt->execute(array($type, $description, $stable));
    }

    //edit version type
    /**
     * @param $id
     * @param $type
     * @param $description
     * @param $stable
     */
    public static function edit_type($id, $type, $description, $stable) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_type = ?, description = ?, version_stability = ? WHERE id = ?");
        $stmt->execute(array($type, $description, $stable, $id));
    }

    //delete version type
    /**
     * @param $id
     */
    public static function delete_type($id) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    /**
     * @param $type
     * @return bool
     */
    public static function stable($type) {
        return (value("version_types", "version_stability", " WHERE version_type = ?", array($type)) == '1') ? true : false;
    }

    /**
     * @param $id
     * @return array
     */
    public static function type_details($id) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("SELECT version_type, description, version_stability FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $return = array();
        $return['name'] = $result['version_type'];
        $return['description'] = $result['description'];
        $return['stability'] = $result['version_stability'];
        return $return;
    }
}