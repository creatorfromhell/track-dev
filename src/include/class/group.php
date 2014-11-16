<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 11:02 AM
 * Version: Beta 1
 * Last Modified: 8/9/14 at 2:23 AM
 * Last Modified by Daniel Vidmar.
 */

class Group {
    public $id = null;
    public $name = null;
    public $admin = null;
    public $permissions = array();
    public $preset = null;

    public function hasPermission($id) {
        foreach($this->permissions as &$perm) {
            if($perm == $id) {
                return true;
            }
        }
        return false;
    }

    public function isAdmin() {
        return ($this->admin == 1) ? true : false;
    }

    public function save() {
        global $pdo, $prefix;
        $perm = implode(",", $this->permissions);
        $t = $prefix."_groups";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET group_name = ?, group_permissions = ?, group_admin = ?, group_preset = ? WHERE id = ?");
        $stmt->execute(array($this->name, $perm, $this->admin, $this->preset, $this->id));
    }

    public static function addGroup($group) {
        if(!is_a($group, "Group")) { return; }
        global $pdo, $prefix;
        $t = $prefix."_groups";
        $perm = implode(",", $group->permissions);
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, group_name, group_permissions, group_admin, group_preset) VALUES(?, ?, ?, ?, ?)");
        $stmt->execute(array($group->id, $group->name, $perm, $group->admin, $group->preset));
    }

    public static function load($id) {
        global $pdo, $prefix;
        $t = $prefix."_groups";
        $group = new Group();
        $stmt = $pdo->prepare("SELECT group_name, group_permissions, group_admin, group_preset FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $group->id = $id;
        $group->name = $result['group_name'];
        $group->permissions = explode(",", $result['group_permissions']);
        $group->admin = $result['group_admin'];
        $group->preset = $result['group_preset'];
        return $group;
    }

    public static function preset() {
        return value("groups", "id", " WHERE group_preset = 1");
    }

    public static function delete($id) {
        global $pdo, $prefix;
        $t = $prefix."_groups";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }
}