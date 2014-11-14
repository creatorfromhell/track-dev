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
    public static function addVersion($version, $project, $status, $due, $released, $type) {
		global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, version_name, project, version_status, due, released, version_type) VALUES ('', ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $status);
        $stmt->bindParam(4, $due);
        $stmt->bindParam(5, $released);
        $stmt->bindParam(6, $type);
        $stmt->execute();
    }

    //delete version
    public static function deleteVersion($id) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //edit version
    public static function editVersion($id, $version, $project, $status, $due, $released, $type) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_name = ?, project = ?, version_status = ?, due = ?, released = ?, version_type = ? WHERE id = ?");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $status);
        $stmt->bindParam(4, $due);
        $stmt->bindParam(5, $released);
        $stmt->bindParam(6, $type);
        $stmt->bindParam(7, $id);
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
	
	public static function getProject($id) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("SELECT project FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['project'];
	}

    //reversion version
    public static function renameVersion($id, $version) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_name = ? WHERE id = ?");
        $stmt->bindParam(1, $version);
        $stmt->bindParam(2, $id);
        $stmt->execute();
    }
	
	public static function hasVersions($project) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("SELECT id FROM `".$t."` WHERE project = ?");
		$stmt->bindParam(1, $project);
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_NUM) > 0) {
            return true;
        }
        return false;
	}
	
	public static function versions($project) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("SELECT version_name FROM `".$t."` WHERE project = ?");
		$stmt->bindParam(1, $project);
        $stmt->execute();
        $result = $stmt->fetchAll();

		$versions = array();
		for($i = 0; $i < count($result); $i++) {
			$versions[$i] = $result[$i][0];
		}
		return $versions;
	}
	
	public static function versionDetails($id) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("SELECT version_name, project, version_status, due, released, version_type FROM `".$t."` WHERE id = ?");
		$stmt->bindParam(1, $id);
        $stmt->execute();
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
	
	public static function versionExists($name) {
        global $prefix, $pdo;
        $t = $prefix."_versions";
        $stmt = $pdo->prepare("SELECT id FROM `".$t."` WHERE version_name = ?");
        $stmt->bindParam(1, $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
	}
	
	public static function printAddForm($project) {
		$out = '';
		$out .= '<h3>Add Version</h3>';
		$out .= '<div id="holder">';
		$out .= '<div id="page_1">';
		$out .= '<fieldset id="inputs">';
		$out .= '<input name="project" type="hidden" value="'.$project.'">';
		$out .= '<input id="version-name" name="version-name" type="text" placeholder="Name">';
		$out .= '<label for="status">Status:</label>';
		$out .= '<select name="status" id="status">';
		$out .= '<option value="0" selected>None</option>';
		$out .= '<option value="1">Upcoming</option>';
		$out .= '<option value="2">Released</option>';
		$out .= '</select><br />';
		$out .= '<label for="version-type">Version Type:</label>';
		$out .= '<select name="version-type" id="version-type">';
		$out .= '<option value="0" selected>None</option>';
		$types = self::types($project);
		foreach($types as &$type) {
			$out .= '<option value="'.$type.'">'.$type.'</option>';
		}
		$out .= '</select><br />';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '<div id="page_2">';
		$out .= '<fieldset id="inputs">';
		$out .= '<label for="due-date">Due Date:</label>';
		$out .= '<input id="due-date" name="due-date" type="text" placeholder="YYYY-MM-DD" readonly>';
		$out .= '<input type="hidden" name="MAX_FILE_SIZE" value="30000" />';
		$out .= 'Download: <input name="version_download" type="file" /><br />';
		$captcha = new Captcha();
        $out .= $captcha->returnImage();
        $_SESSION['userspluscaptcha'] = $captcha->code;
		$out .= '<br /><input id="captcha" name="captcha" type="text" placeholder="Enter characters above">';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
		$out .= '<input type="submit" class="submit" name="add-version" value="Add">';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '</div>';
		return $out;
	}

    public static function printEditForm($id) {
		$out = '';
		$details = self::versionDetails($id);
		$out .= '<h3>Edit Version</h3>';
		$out .= '<div id="holder">';
		$out .= '<div id="page_1">';
		$out .= '<fieldset id="inputs">';
        $out .= '<input name="id" type="hidden" value="'.$id.'">';
		$out .= '<input name="project" type="hidden" value="'.$details['project'].'">';
		$out .= '<input id="version-name" name="version-name" type="text" placeholder="Name" value="'.$details['name'].'">';
		$out .= '<label for="status">Status:</label>';
		$out .= '<select name="status" id="status">';
		$out .= '<option value="0"'.(($details['status'] == '0') ? ' selected' : '').'>None</option>';
		$out .= '<option value="1"'.(($details['status'] == '1') ? ' selected' : '').'>Upcoming</option>';
		$out .= '<option value="2"'.(($details['status'] == '2') ? ' selected' : '').'>Released</option>';
		$out .= '</select><br />';
		$out .= '<label for="version-type">Version Type:</label>';
		$out .= '<select name="version-type" id="version-type">';
		$out .= '<option value="none"'.(($details['type'] == 'none') ? ' selected' : '').'>None</option>';
		$types = self::types($details['project']);
		foreach($types as &$type) {
			$out .= '<option value="'.$type.'"'.(($details['type'] == $type) ? ' selected' : '').'>'.$type.'</option>';
		}
		$out .= '</select><br />';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '<div id="page_2">';
		$out .= '<fieldset id="inputs">';
		$out .= '<label for="due-date">Due Date:</label>';
		$out .= '<input id="due-date" name="due-date" type="text" placeholder="YYYY-MM-DD" value="'.$details['due'].'" readonly>';
		$out .= 'Current Download: Name.zip 25kb<br />';
		$out .= '<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />';
		$out .= 'Download: <input name="version_download" type="file" /><br />';
		$captcha = new Captcha();
        $out .= $captcha->returnImage();
        $_SESSION['userspluscaptcha'] = $captcha->code;
		$out .= '<br /><input id="captcha" name="captcha" type="text" placeholder="Enter characters above">';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
		$out .= '<input type="submit" class="submit" name="edit-version" value="Edit">';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '</div>';
		return $out;
    }


    /*
     * Version Type Functions
     */

    //add version type
    public static function addType($type, $description, $stable) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, version_type, description, version_stability) VALUES ('', ?, ?, ?)");
        $stmt->bindParam(1, $type);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $stable);
        $stmt->execute();
    }

    //edit version type
    public static function editType($id, $type, $description, $stable) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("UPDATE `".$t."` SET version_type = ?, description = ?, version_stability = ? WHERE id = ?");
        $stmt->bindParam(1, $type);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $stable);
        $stmt->bindParam(4, $id);
        $stmt->execute();
    }

    //delete version type
    public static function deleteType($id) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }
	
	public static function stable($type) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
		$stmt = $pdo->prepare("SELECT version_stability FROM `".$t."` WHERE version_type = ?");
		$stmt->bindParam(1, $type);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result['version_stability'] == '1') {
			return true;
		}
		return false;
	}
	
	public static function hasTypes() {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("SELECT id FROM `".$t."`");
        $stmt->execute();
        if($stmt->fetch(PDO::FETCH_NUM) > 0) {
            return true;
        }
        return false;
	}
	
	public static function types($project) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("SELECT version_type FROM `".$t."`");
		$stmt->bindParam(1, $project);
        $stmt->execute();
        $result = $stmt->fetchAll();

		$types = array();
		for($i = 0; $i < count($result); $i++) {
			$types[$i] = $result[$i][0];
		}
		return $types;
	}
	
	public static function typeDetails($id) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("SELECT version_type, description, version_stability FROM `".$t."` WHERE id = ?");
		$stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $return = array();
        $return['name'] = $result['version_type'];
        $return['description'] = $result['description'];
        $return['stability'] = $result['version_stability'];
        return $return;
	}
	
	public static function typeExists($name) {
        global $prefix, $pdo;
        $t = $prefix."_version_types";
        $stmt = $pdo->prepare("SELECT id FROM `".$t."` WHERE version_type = ?");
        $stmt->bindParam(1, $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
	}
	
	public static function printTypeAddForm() {
		$out = '';
		$out .= '<h3>Add Version Type</h3>';
		$out .= '<div id="holder">';
		$out .= '<div id="page_1">';
		$out .= '<fieldset id="inputs">';
		$out .= '<input id="type-name" name="type-name" type="text" placeholder="Name">';
		$out .= '<textarea id="type-description" name="type-description" ROWS="3" COLS="40"></textarea>';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '<div id="page_2">';
		$out .= '<fieldset id="inputs">';
		$out .= '<label for="type-stable">Stable:</label>';
		$out .= '<select name="type-stable" id="type-stable">';
		$out .= '<option value="0" selected>No</option>';
		$out .= '<option value="1">Yes</option>';
		$out .= '</select><br />';
		$captcha = new Captcha();
        $out .= $captcha->returnImage();
        $_SESSION['userspluscaptcha'] = $captcha->code;
		$out .= '<br /><input id="captcha" name="captcha" type="text" placeholder="Enter characters above">';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
		$out .= '<input type="submit" class="submit" name="add-version-type" value="Add">';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '</div>';
		return $out;
	}

    public static function printTypeEditForm($id) {
		$out = '';
		$details = self::typeDetails($id);
		$out .= '<h3>Edit Version Type</h3>';
		$out .= '<div id="holder">';
		$out .= '<div id="page_1">';
		$out .= '<fieldset id="inputs">';
        $out .= '<input name="id" type="hidden" value="'.$id.'">';
		$out .= '<input id="type-name" name="type-name" type="text" placeholder="Name" value="'.$details['name'].'">';
		$out .= '<textarea id="type-description" name="type-description" ROWS="3" COLS="40">'.$details['description'].'</textarea>';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit" onclick="switchPage(event, \'page_1\', \'page_2\'); return false;">Next</button>';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '<div id="page_2">';
		$out .= '<fieldset id="inputs">';
        $out .= '<label for="type-stable">Stable:</label>';
		$out .= '<select name="type-stable" id="type-stable">';
		$out .= '<option value="0"'.(($details['stability'] == "0") ? " selected" : "").'>No</option>';
		$out .= '<option value="1"'.(($details['stability'] == "1") ? " selected" : "").'>Yes</option>';
		$out .= '</select><br />';
		$captcha = new Captcha();
        $out .= $captcha->returnImage();
        $_SESSION['userspluscaptcha'] = $captcha->code;
		$out .= '<br /><input id="captcha" name="captcha" type="text" placeholder="Enter characters above">';
		$out .= '</fieldset>';
		$out .= '<fieldset id="links">';
		$out .= '<button class="submit_2" onclick="switchPage(event, \'page_2\', \'page_1\'); return false;">Back</button>';
		$out .= '<input type="submit" class="submit" name="edit-version-type" value="Edit">';
		$out .= '</fieldset>';
		$out .= '</div>';
		$out .= '</div>';
		return $out;
    }
}
?>