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
require_once("include/connect.php");
class GroupFunc {

    //add group function
    public static function add($groupname, $permission, $preset, $admin) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, groupname, permission, preset, admin) VALUES ('', ?, ?, ?, ?)");
        $stmt->bindParam(1, $groupname);
        $stmt->bindParam(2, $permission);
        $stmt->bindParam(3, $preset);
        $stmt->bindParam(4, $admin);
        $stmt->execute();
    }

    //edit group function
    public static function edit($id, $groupname, $permission, $preset, $admin) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE `".$t."` SET groupname = ?, permission = ?, preset = ?, admin = ? WHERE id = ?");
        $stmt->bindParam(1, $groupname);
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
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //change group perm
    public static function changePermission($id, $permission) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE `".$t."` SET permission = ? WHERE id = ?");
        $stmt->bindParam(1, $permission);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //get group perm
    public static function permission($group) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT permission FROM `".$t."` WHERE groupname = ?");
        $stmt->bindParam(1, $group);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['permission'];
    }

    //exists
    public static function exists($group) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE groupname = ?");
        $stmt->bindParam(1, $group);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
    }

    public static function getName($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT groupname FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['groupname'];
    }

    //get preset
    public static function getPreset() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE preset = 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    //make admin
    public static function makeAdmin($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE `".$t."` SET admin = 1 WHERE id = ?");
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
        $stmt = $c->prepare("UPDATE `".$t."` SET preset = 0 WHERE id = ?");
        $stmt->bindParam(1, $current);
        $stmt->execute();

        //Set the new group to the preset group
        $stmt = $c->prepare("UPDATE `".$t."` SET preset = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //regroupname group
    public static function rename($id, $groupname) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("UPDATE `".$t."` SET groupname = ? WHERE id = ?");
        $stmt->bindParam(1, $groupname);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }

    //is admin
    public static function isAdmin($group) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT admin FROM `".$t."` WHERE groupname = ?");
        $stmt->bindParam(1, $group);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin = $result['admin'];

        if($admin == 1) {
            return true;
        }
        return false;
    }

    public static function printGroups($username, $formatter) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT id, groupname, permission, admin FROM `".$t."` ORDER BY permission ASC");
        $stmt->bindParam(1, $project);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['groupname'];
            $permission = $row['permission'];
            $a = $row['admin'];
            $admin = ($a == "1") ? (string)$formatter->languageinstance->site->tables->yes : (string)$formatter->languageinstance->site->tables->no;


            echo "<tr>";
            echo "<td class='name'>".$formatter->replace($name)."</td>";
            echo "<td class='permission'>".$formatter->replace($permission)."</td>";
            echo "<td class='admin'>".$formatter->replace($admin)."</td>";
            echo "<td class='actions'>";

            //check if the user is an admin just for extra measure even though they
            //shouldn't be able to access this page if they aren't
            if(UserFunc::isAdmin($username)) {
                echo "<a title='Edit' class='actionEdit'  href='?t=groups&action=edit&id=".$id."'></a>";
                echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?t=groups&action=delete&id=".$id."'></a>";
            } else {
                echo $formatter->replace("%none");
            }

            echo "</td>";
            echo "</tr>";
        }
    }

    public static function printEditForm($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT groupname, permission, preset, admin FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $out = '';
        $out .= '<form id="group_edit" class="trackrForm" method="post">';
        $out .= '<h3>Edit Group</h3>';
        $out .= '<div id="holder">';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input id="id" name="id" type="hidden" value="'.$id.'">';
        $out .= '<input id="name" name="name" type="text" placeholder="Name" value="'.$result['groupname'].'">';
        $out .= '<label for="permission">Permission:<label id="permission_value">'.$result['permission'].'</label></label><br />';
        $out .= '<input type="range" id="permission" name="permission" value="'.$result['permission'].'" min="0" max="999" oninput="showValue(\'permission_value\', this.value);">';
        $out .= '<label for="preset">Preset:</label>';
        $out .= '<select name="preset" id="preset">';
        $out .= '<option value="0" ';
        $out .= ($result["preset"] == 0) ? "selected" : "";
        $out .= '>No</option>';
        $out .= '<option value="1" ';
        $out .= ($result["preset"] == 1) ? "selected" : "";
        $out .= '>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="admin">Administrator:</label>';
        $out .= '<select name="admin" id="admin">';
        $out .= '<option value="0" ';
        $out .= ($result["admin"] == 0) ? "selected" : "";
        $out .= '>No</option>';
        $out .= '<option value="1" ';
        $out .= ($result["admin"] == 1) ? "selected" : "";
        $out .= '>Yes</option>';
        $out .= '</select><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button id="submit_2" onclick="hideDiv(\'group_edit\'); return false;">Close</button>';
        $out .= '<input type="submit" id="submit" name="edit" value="Submit">';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</form>';

        return $out;
    }
}
?>