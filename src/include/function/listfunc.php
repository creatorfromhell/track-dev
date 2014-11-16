<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 1:05 PM
 * Last Modified by Daniel Vidmar.
 */
require_once("include/function/projectfunc.php");
class ListFunc {

    //add list
    public static function addList($list, $project, $public, $creator, $created, $overseer, $minimal, $guestview, $guestedit, $viewpermission, $editpermission) {
		$guestPermissions = "view:".$guestview.",edit:".$guestedit;
        $listPermissions = "view:".$viewpermission.",edit:".$editpermission;
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, list, project, public, creator, created, overseer, minimal_view, guest_permissions, list_permissions) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($list, $project, $public, $creator, $created, $overseer, $minimal, $guestPermissions, $listPermissions));
    }

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

    public static function remove($id) {
        $project = self::getProject($id);
        $list = self::getName($id);
        global $prefix, $pdo;
        $t = $prefix."_".$project."_".$list;
        $stmt = $pdo->prepare("DROP TABLE IF EXISTS `".$t."`");
        $stmt->execute();
        self::deleteList($id);
    }

    //delete list
    public static function deleteList($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    //edit list
    public static function editList($id, $list, $project, $public, $overseer, $minimal, $guestview, $guestedit, $viewpermission, $editpermission) {
        $guestPermissions = "view:".$guestview.",edit:".$guestedit;
        $listPermissions = "view:".$viewpermission.",edit:".$editpermission;
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET project = ?, list = ?, public = ?, overseer = ?, minimal_view = ?, guest_permissions = ?, list_permissions = ? WHERE id = ?");
        $stmt->execute(array($project, $list, $public, $overseer, $minimal, $guestPermissions, $listPermissions, $id));
    }

    //return all the configuration options for this list
    public static function configurations($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT public, minimal_view, guest_permissions, list_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function guestView($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT guest_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(explode(':', explode(',', $result['guest_permissions'])[0])[1] == '1') {
            return true;
        }
        return false;
    }

    public static function guestEdit($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT guest_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(explode(':', explode(',', $result['guest_permissions'])[1])[1] == '1') {
            return true;
        }
        return false;
    }

    public static function editPermission($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT list_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return explode(':', explode(',', $result['list_permissions'])[1])[1];
    }

    public static function viewPermission($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT list_permissions FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return explode(':', explode(',', $result['list_permissions'])[0])[1];
    }

    //get list id
    public static function getID($project, $list) {
        return value("lists", "id", " WHERE project = '".cleanInput($project)."' AND list = '".cleanInput($list)."'");
    }

    public static function listDetails($id) {
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

    public static function minimal($id) {
        return (value("lists", "minimal_view", " WHERE id = '".cleanInput($id)."'") == '1') ? true : false;
    }

    public static function getOverseer($id) {
        return value("lists", "overseer", " WHERE id = '".cleanInput($id)."'");
    }

    public static function getProject($id) {
        return value("lists", "project", " WHERE id = '".cleanInput($id)."'");
    }

    //change list project
    public static function changeProject($id, $project) {
        $details = self::listDetails($id);
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET project = ? WHERE id = ?");
        $stmt->execute(array($project, $id));
        $t = $prefix."_".$details['project']."_".$details['name'];
        $t2 = $prefix."_".$project."_".$details['name'];
        $stmt = $pdo->prepare("RENAME TABLE `".$t."` TO `".$t2."`");
        $stmt->execute();
    }

    //make list private
    public static function makePrivate($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET public = 0 WHERE id = ?");
        $stmt->execute(array($id));
    }

    public static function getName($id) {
        return value("lists", "list", " WHERE id = '".cleanInput($id)."'");
    }

    //make list public
    public static function makePublic($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET public = 1 WHERE id = ?");
        $stmt->execute(array($id));
    }

    //rename list
    public static function renameList($id, $list) {
        $details = self::listDetails($id);
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET list = ? WHERE id = ?");
        $stmt->execute(array($list, $id));
        $t = $prefix."_".$details['project']."_".$details['name'];
        $t2 = $prefix."_".$details['project']."_".$list;
        $stmt = $pdo->prepare("RENAME TABLE `".$t."` TO `".$t2."`");
        $stmt->execute();
    }

    public static function printAddForm($project, $projects, $username) {
        $out = '';
        $out .= '<h3>Add List</h3>';
        $out .= '<div id="holder">';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input id="name" name="name" type="text" placeholder="Name">';
        $out .= '<input id="author" name="author" type="hidden" value="'.$username.'">';
        $out .= '<label for="project">Project:</label>';
        $out .= '<select name="project" id="project">';
        $out .= toOptions($projects, $project);
        $out .= '</select><br />';
        $out .= '<label for="public">Public:</label>';
        $out .= '<select name="public" id="public">';
        $out .= '<option value="0">No</option>';
        $out .= '<option value="1" selected>Yes</option>';
        $out .= '</select><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_2">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="minimal">Minimal View:</label>';
        $out .= '<select name="minimal" id="minimal">';
        $out .= '<option value="0" selected>No</option>';
        $out .= '<option value="1">Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="mainlist">Main:</label>';
        $out .= '<select name="mainlist" id="mainlist">';
        $out .= '<option value="0" selected>No</option>';
        $out .= '<option value="1">Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="overseer">Overseer:</label>';
        $out .= '<select name="overseer" id="overseer">';
        $out .= '<option value="none" selected>None</option>';
        $out .= toOptions(values("users", "user_name"));
        $out .= '</select>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
        $out .= '<button class="submit" onclick="switchPage(event, \'page_2\', \'page_3\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_3">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="guestview">Guest View:</label>';
        $out .= '<select name="guestview" id="guestview">';
        $out .= '<option value="0">No</option>';
        $out .= '<option value="1" selected>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="guestedit">Guest Edit:</label>';
        $out .= '<select name="guestedit" id="guestedit">';
        $out .= '<option value="0" selected>No</option>';
        $out .= '<option value="1">Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="viewpermission">View Permission:</label>';
        $out .= '<select name="viewpermission" id="viewpermission">';
        $out .= '<option value="none" selected>None</option>';
		$nodes = values("nodes", "node_name");
        foreach($nodes as &$node) {
            $out .= '<option value="'.nodeID($node).'">'.$node.'</option>';
        }
        $out .= '</select><br />';
        $out .= '<label for="editpermission">Edit Permission:</label>';
        $out .= '<select name="editpermission" id="editpermission">';
        $out .= '<option value="none" selected>None</option>';
		$nodes = values("nodes", "node_name");
        foreach($nodes as &$node) {
            $out .= '<option value="'.nodeID($node).'">'.$node.'</option>';
        }
        $out .= '</select><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_3\', \'page_2\'); return false;">Back</button>';
        $out .= '<input type="submit" class="submit" name="add-list" value="Add">';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</form>';

        return $out;
    }

    public static function printEditForm($id) {
        global $prefix, $pdo;
        $t = $prefix."_lists";
        $stmt = $pdo->prepare("SELECT list, project, public, overseer, minimal_view FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $main = ProjectFunc::getMain($result['project']);

        $out = '';
        $out .= '<h3>Edit List</h3>';
        $out .= '<div id="holder">';
        $out .= '<div id="page_1">';
        $out .= '<fieldset id="inputs">';
        $out .= '<input id="id" name="id" type="hidden" value="'.$id.'">';
        $out .= '<input id="name" name="name" type="text" placeholder="Name" value="'.$result['list'].'">';
        $out .= '<label for="project">Project:</label>';
        $out .= '<select name="project" id="project">';
        $out .= toOptions(values("projects", "project"), $result['project']);
        $out .= '</select><br />';
        $out .= '<label for="public">Public:</label>';
        $out .= '<select name="public" id="public">';
        $out .= '<option value="0"'.(($result['public'] == 0) ? ' selected' : '').'>No</option>';
        $out .= '<option value="1"'.(($result['public'] == 1) ? ' selected' : '').'>Yes</option>';
        $out .= '</select><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button id="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_2">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="minimal">Minimal View:</label>';
        $out .= '<select name="minimal" id="minimal">';
        $out .= '<option value="0"'.(($result['minimal_view'] == 0) ? ' selected' : '').'>No</option>';
        $out .= '<option value="1"'.(($result['minimal_view'] == 1) ? ' selected' : '').'>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="mainlist">Main:</label>';
        $out .= '<select name="mainlist" id="mainlist">';
        $out .= '<option value="0"'.(($main != $id) ?' selected' : '').'>No</option>';
        $out .= '<option value="1"'.(($main == $id) ? ' selected' : '').'>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="overseer">Overseer:</label>';
        $out .= '<select name="overseer" id="overseer">';
        $out .= '<option value="none"'.(($result['overseer'] == 'none') ? ' selected' : '').'>None</option>';
        $out .= toOptions(values("users", "user_name"), $result['overseer']);
        $out .= '</select>';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
        $out .= '<button class="submit" onclick="switchPage(event, \'page_2\', \'page_3\'); return false;">Next</button>';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '<div id="page_3">';
        $out .= '<fieldset id="inputs">';
        $out .= '<label for="guestview">Guest View:</label>';
        $out .= '<select name="guestview" id="guestview">';
        $out .= '<option value="0"'.((!self::guestView($id)) ? ' selected' : '').'>No</option>';
        $out .= '<option value="1"'.((self::guestView($id)) ? ' selected' : '').'>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="guestedit">Guest Edit:</label>';
        $out .= '<select name="guestedit" id="guestedit">';
        $out .= '<option value="0"'.((!self::guestEdit($id)) ? ' selected' : '').'>No</option>';
        $out .= '<option value="1"'.((self::guestEdit($id)) ? ' selected' : '').'>Yes</option>';
        $out .= '</select><br />';
        $out .= '<label for="viewpermission">View Permission:</label>';
        $out .= '<select name="viewpermission" id="viewpermission">';
        $out .= '<option value="none"'.((self::viewPermission($id) == 'none') ? ' selected' : '').'>None</option>';
		$nodes = values("nodes", "node_name");
        foreach($nodes as &$node) {
            $out .= '<option value="'.nodeID($node).'"'.((self::viewPermission($id) == $node) ? ' selected' : '').'>'.$node.'</option>';
        }
        $out .= '</select><br />';
        $out .= '<label for="editpermission">Edit Permission:</label>';
        $out .= '<select name="editpermission" id="editpermission">';
        $out .= '<option value="none"'.((self::editPermission($id) == "none") ? ' selected' : '').'>None</option>';
		$nodes = values("nodes", "node_name");
        foreach($nodes as &$node) {
            $out .= '<option value="'.nodeID($node).'"'.((self::editPermission($id) == $node) ? ' selected' : '').'>'.$node.'</option>';
        }
        $out .= '</select><br />';
        $out .= '</fieldset>';
        $out .= '<fieldset id="links">';
        $out .= '<button class="submit_2" onclick="switchPage(event, \'page_3\', \'page_2\'); return false;">Back</button>';
        $out .= '<input type="submit" class="submit" name="edit-list" value="Submit">';
        $out .= '</fieldset>';
        $out .= '</div>';
        $out .= '</div>';

        return $out;
    }
}
?>