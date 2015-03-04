<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */
require_once("include/function/ProjectFunc.php");

/**
 * Class ListFunc
 */
class ListFunc {

    //add list
    /**
     * @param $list
     * @param $project
     * @param $public
     * @param $creator
     * @param $created
     * @param $overseer
     * @param $minimal
     * @param $guestview
     * @param $guestedit
     * @param $viewpermission
     * @param $editpermission
     */
    public static function add_list($list, $project, $public, $creator, $created, $overseer, $minimal, $guest_view, $guest_edit, $view_permission, $edit_permission) {
		$guest_permissions = "view:".$guest_view.",edit:".$guest_edit;
        $list_permissions = "view:".$view_permission.",edit:".$edit_permission;
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, list, project, public, creator, created, overseer, minimal_view, guest_permissions, list_permissions) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($list, $project, $public, $creator, $created, $overseer, $minimal, $guest_permissions, $list_permissions));
    }

    /**
     * @param $project
     * @param $list
     */
    public static function create($project, $list) {
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $pdo->exec("CREATE TABLE IF NOT EXISTS `".$t."` (
                              `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                              `title` varchar(40) NOT NULL,
                              `description` text NOT NULL,
                              `author` varchar(40) NOT NULL,
                              `assignee` varchar(40) NOT NULL,
                              `due` date NOT NULL DEFAULT '0000-00-00',
                              `created` date NOT NULL DEFAULT '0000-00-00',
                              `finished` date NOT NULL DEFAULT '0000-00-00',
                              `version_name` varchar(40) NOT NULL,
                              `labels` text NOT NULL,
                              `editable` tinyint(1) NOT NULL DEFAULT '1',
                              `task_status` tinyint(3) NOT NULL DEFAULT '0',
                              `progress` tinyint(3) NOT NULL DEFAULT '0'
                            );");
    }

    /**
     * @param $id
     */
    public static function remove($id) {
        $project = self::get_project($id);
        $list = self::get_name($id);
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("DROP TABLE IF EXISTS `".$t."`");
        $stmt->execute();
        self::delete_list($id);
    }

    //delete list
    /**
     * @param $id
     */
    public static function delete_list($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //edit list
    /**
     * @param $id
     * @param $list
     * @param $project
     * @param $public
     * @param $overseer
     * @param $minimal
     * @param $guestview
     * @param $guestedit
     * @param $viewpermission
     * @param $editpermission
     */
    public static function edit_list($id, $list, $project, $public, $overseer, $minimal, $guest_view, $guest_edit, $view_permission, $edit_permission) {
        $guest_permissions = "view:".$guest_view.",edit:".$guest_edit;
        $list_permissions = "view:".$view_permission.",edit:".$edit_permission;
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET project = ?, list = ?, public = ?, overseer = ?, minimal_view = ?, guest_permissions = ?, list_permissions = ? WHERE id = ?");
        $stmt->execute(array($project, $list, $public, $overseer, $minimal, $guest_permissions, $list_permissions, $id));
    }

    //return all the configuration options for this list
    /**
     * @param $id
     * @return mixed
     */
    public static function configurations($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT public, minimal_view, guest_permissions, list_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function guest_permissions($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT guest_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $permissions = explode(',', $result['guest_permissions']);

        $return = array(
            'view' => explode(':', $permissions[0])[1],
            'edit' => explode(':', $permissions[1])[1],
        );
        return $return;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function edit_permission($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT list_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return explode(':', explode(',', $result['list_permissions'])[1])[1];
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function view_permission($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT list_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return explode(':', explode(',', $result['list_permissions'])[0])[1];
    }

    //get list id
    /**
     * @param $project
     * @param $list
     * @return mixed
     */
    public static function get_id($project, $list) {
        return value("lists", "id", " WHERE project = ? AND list = ?", array($project, $list));
    }

    /**
     * @param $id
     * @return array
     */
    public static function list_details($id) {
        $return = array();
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT list, project, public, creator, created, overseer FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $return['name'] = $result['list'];
        $return['project'] = $result['project'];
        $return['public'] = $result['public'];
        $return['creator'] = $result['creator'];
        $return['created'] = $result['created'];
        $return['overseer'] = $result['overseer'];

        return $return;
    }

    /**
     * @param $id
     * @return bool
     */
    public static function minimal($id) {
        return (value("lists", "minimal_view", " WHERE id = ?", array($id)) == '1') ? true : false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function get_overseer($id) {
        return value("lists", "overseer", " WHERE id = ?", array($id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function get_project($id) {
        return value("lists", "project", " WHERE id = ?", array($id));
    }

    //change list project
    /**
     * @param $id
     * @param $project
     */
    public static function change_project($id, $project) {
        $details = self::list_details($id);
        global $prefix, $pdo;
        set_value("lists", "project", $project, " WHERE id = ?", array($id));
        $t = $prefix."_".$details['project']."_".$details['name'];
        $t2 = $prefix."_".$project."_".$details['name'];
        $stmt = $pdo->prepare("RENAME TABLE `".$t."` TO `".$t2."`");
        $stmt->execute();
    }

    //make list private
    /**
     * @param $id
     */
    public static function make_private($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET public = 0 WHERE id = ?");
        $stmt->execute(array($id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function get_name($id) {
        return value("lists", "list", " WHERE id = ?", array($id));
    }

    //make list public
    /**
     * @param $id
     */
    public static function make_public($id) {
        set_value("lists", "public", "1", " WHERE id = ?", array($id));
    }

    //rename list
    /**
     * @param $id
     * @param $list
     */
    public static function rename_list($id, $list) {
        $details = self::list_details($id);
        global $prefix, $pdo;
        set_value("lists", "list", $list, " WHERE id = ?", array($id));
        $t = $prefix."_".$details['project']."_".$details['name'];
        $t2 = $prefix."_".$details['project']."_".$list;
        $stmt = $pdo->prepare("RENAME TABLE `".$t."` TO `".$t2."`");
        $stmt->execute();
    }
}