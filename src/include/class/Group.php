<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 11:02 AM
 * Version: Beta 1
 * Last Modified: 8/9/14 at 2:23 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class Group
 */
class Group {
    /**
     * @var null
     */
    public $id = null;
    /**
     * @var null
     */
    public $name = null;
    /**
     * @var null
     */
    public $admin = null;
    /**
     * @var array
     */
    public $permissions = array();
    /**
     * @var null
     */
    public $preset = null;

    /**
     * @param $id
     * @return bool
     */
    public function has_permission($id) {
        foreach($this->permissions as &$perm) {
            if($perm == $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function is_admin() {
        return ($this->admin == 1) ? true : false;
    }

    /**
     *
     */
    public function save() {
        global $pdo, $prefix;
        $perm = implode(",", $this->permissions);
        $t = $prefix."_groups";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET group_name = ?, group_permissions = ?, group_admin = ?, group_preset = ? WHERE id = ?");
        $stmt->execute(array($this->name, $perm, $this->admin, $this->preset, $this->id));
    }

    /**
     * @param $group
     */
    public static function add_group($group) {
        if(!($group instanceof Group)) { return; }
        global $pdo, $prefix;
        $t = $prefix."_groups";
        $perm = implode(",", $group->permissions);
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, group_name, group_permissions, group_admin, group_preset) VALUES(?, ?, ?, ?, ?)");
        $stmt->execute(array($group->id, $group->name, $perm, $group->admin, $group->preset));
    }

    /**
     * @param $id
     * @return Group
     */
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

    /**
     * @return mixed
     */
    public static function preset() {
        return value("groups", "id", " WHERE group_preset = 1");
    }

    /**
     * @param $id
     */
    public static function delete($id) {
        global $pdo, $prefix;
        $t = $prefix."_groups";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }
}