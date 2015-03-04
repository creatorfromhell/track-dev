<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/6/14
 * Time: 9:42 AM
 * Version: Beta 1
 * Last Modified: 8/9/14 at 3:29 AM
 * Last Modified by Daniel Vidmar.
 */

/*
 * Miscellaneous Functions
 */

/**
 * @param $value
 * @return int
 */
function valid_username($value) {
    return preg_match('/^[a-zA-Z0-9_.-]+$/i', $value);
}

/**
 * @param $value
 * @return mixed
 */
function valid_email($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

/**
 * @param $value
 * @return bool
 */
function check_captcha($value) {
    if($value === null) { return false; }
    if(!isset($_SESSION['userspluscaptcha'])) {
        return false;
    }
    return $_SESSION['userspluscaptcha'] == $value;
}

/**
 * @param $string
 * @param $word
 * @return bool
 */
function str_contains($string, $word) {
    if (strpos($string, $word) !== false) {
        return true;
    }
    return false;
}

/**
 * @param string $table
 * @param string $column
 */
function value($table, $column, $extra = '') {
    global $prefix, $pdo;
    $t = $prefix."_".$table;
    $stmt = $pdo->prepare("SELECT ".$column." FROM `".$t."`".$extra);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result[$column];
}

/**
 * @param string $table
 * @param string $column
 */
function set_value($table, $column, $value, $extra = '') {
    global $prefix, $pdo;
    $t = $prefix."_".$table;
    $stmt = $pdo->prepare("UPDATE `".$t."` SET ".$column." = ?".$extra);
    $stmt->execute(array($value));
}

/**
 * @param string $table
 * @param string $column
 */
function values($table, $column, $extra = '') {
    global $prefix, $pdo;
    $t = $prefix."_".$table;
    $stmt = $pdo->prepare("SELECT ".$column." FROM `".$t."`".$extra);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $values = array();
    foreach($result as &$r) {
        $values[] = $r;
    }
    return $values;
}

/**
 * @param string $table
 */
function has_values($table, $extra = '') {
    if(count_columns($table, $extra) > 0) {
        return true;
    }
    return false;
}

/**
 * @param string $table
 */
function count_columns($table, $extra = '') {
    global $prefix, $pdo;
    $t = $prefix."_".$table;
    $stmt = $pdo->prepare("SELECT * FROM `".$t."`".$extra);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_NUM);
}

/**
 * @param $data
 * @param null $value
 * @return string
 */
function to_options($data, $value = null) {
    $return = '';
    $options = $data;
    foreach($options as &$option) {
        $return .= '<option value="'.$option.'"'.(($value !== null && $value == $option) ? ' selected' : '').'>'.$option.'</option>';
    }
    return $return;
}

/**
 * @param $file
 * @param $name
 * @param int $maxSize
 */
function upload_file($file, $name, $maxSize = 1000000) {
	$type = pathinfo(basename($file['name']), PATHINFO_EXTENSION);
	$move = $name.".".$type;
	$bannedTypes = array("php", "js", "cs");
	
	if(in_array($type, $bannedTypes)) {
		return;
	}
	
	if($file['size'] > $maxSize) {
		return;
	}
	
	if(move_uploaded_file($file['tmp_name'], $move)) {
		return;
	}
	return;
}

/*
 * User Functions
 */
/**
 * @return bool
 */
function is_admin() {
    if(isset($_SESSION['usersplusprofile']) && User::exists($_SESSION['usersplusprofile']) && User::load($_SESSION['usersplusprofile'])->is_admin()) { return true; }
    return false;
}

/**
 * @return string
 */
function get_name() {
    if(isset($_SESSION['usersplusprofile']) && User::exists($_SESSION['usersplusprofile'])) { return $_SESSION['usersplusprofile']; }
    return "Guest(".User::get_ip().")";
}

/**
 *
 */
function latest_users() {
    //new method values("users", "user_name", " ORDER BY user_registered DESC LIMIT 7");
}

/**
 * @return string
 */
function user_nav() {
    $out = '';
    $out .= '<nav class="userNav">';
    $out .= '<ul><li><a href="#">'.get_name().'</a>';
    $out .= '<ul>';
    if(is_admin()) {
        $out .= '<li><a href="admin.php">Admin</a></li>';
    }
    $out .= '<li><a href="logout.php">Logout</a></li>';
    $out .= '</ul></ul></nav>';
    return $out;
}

/**
 * @param $id
 * @return bool
 */
function can_view_list($id) {
    $viewPermission = ListFunc::view_permission($id);
    if(ListFunc::guest_permissions($id)['view']) { return true; }
    if(!isset($_SESSION['usersplusprofile']) || !User::exists($_SESSION['usersplusprofile'])) { return false; }
    if(is_admin()) { return true; }
    if(ProjectFunc::get_overseer(ListFunc::get_project($id)) == get_name() || ListFunc::get_overseer($id) == get_name()) { return true; }
	$user = User::load($_SESSION['usersplusprofile']);
    if($viewPermission != "none" && has_values("nodes", " WHERE id = '".StringFormatter::clean_input($viewPermission)."'") && $user->has_permission($viewPermission)) { return true; }
    return false;
}

/**
 * @param $id
 * @return bool
 */
function can_edit_list($id) {
    $editPermission = ListFunc::edit_permission($id);
    if(ListFunc::guest_permissions($id)['edit']) { return true; }
    if(!isset($_SESSION['usersplusprofile']) || !User::exists($_SESSION['usersplusprofile'])) { return false; }
    if(is_admin()) { return true; }
    if(ProjectFunc::get_overseer(ListFunc::get_project($id)) == get_name() || ListFunc::get_overseer($id) == get_name()) { return true; }
    $user = User::load($_SESSION['usersplusprofile']);
	if($editPermission != "none" && has_values("nodes", " WHERE id = '".StringFormatter::clean_input($editPermission)."'") && $user->has_permission($editPermission)) { return true; }
    return false;
}

/**
 * @param $listID
 * @param $taskID
 * @return bool
 */
function can_edit_task($listID, $taskID) {
    $editPermission = ListFunc::edit_permission($listID);
    if(ListFunc::guest_permissions($listID)['edit']) { return true; }
    if(!isset($_SESSION['usersplusprofile']) || !User::exists($_SESSION['usersplusprofile'])) { return false; }
    if(is_admin()) { return true; }
    if(ProjectFunc::get_overseer(ListFunc::get_project($listID)) == get_name() || ListFunc::get_overseer($listID) == get_name()) { return true; }
    $details = TaskFunc::task_details(ListFunc::get_project($listID), ListFunc::get_name($listID), $taskID);
    if($details['author'] == get_name()) { return true; }
	$user = User::load($_SESSION['usersplusprofile']);
    if($editPermission != "none" && has_values("nodes", " WHERE id = '".StringFormatter::clean_input($editPermission)."'") && $user->has_permission($editPermission) && $details['editable'] == '1') { return true; }
    return false;
}

/**
 * @return bool
 */
function logged_in() {
    return (check_session("usersplusprofile"));
}

/*
 * Page Functions
 */
/**
 * @param $user
 * @param string $node
 * @param bool $guest
 * @param bool $admin
 * @param string $group
 * @param bool $useGroup
 * @param string $name
 * @param bool $useName
 * @return bool
 */
function page_locked($user, $node = "", $guest = false, $admin = false, $group = "", $useGroup = false, $name = "", $useName = false) {
    if($useGroup) { return page_locked_group($user, $group); }
    if($useName) { return page_locked_user($user, $name); }
    if($admin) { return page_locked_admin($user); }
    return page_locked_node($user, $node, $guest);
}

/**
 * @param string $node
 */
function page_locked_node($user, $node, $guest = false) {
    if($guest) { return false; }
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->is_admin()) { return false; }
    if(!has_values("nodes", " WHERE node_name = '".StringFormatter::clean_input($node)."'")) { return true; }
    if($user->hasPermission(node_id($node))) { return false; }
    if($user->group->hasPermission(node_id($node))) { return false; }
    return true;
}

/**
 * @param $user
 * @return bool
 */
function page_locked_admin($user) {
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->is_admin()) { return false; }
    return true;
}

/**
 * @param string $group
 */
function page_locked_group($user, $group) {
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->is_admin()) { return false; }
    if($user->group->id == $group) { return false; }
    return true;
}

/**
 * @param string $name
 */
function page_locked_user($user, $name) {
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->is_admin()) { return false; }
    if($user->name == $name) { return false; }
    return true;
}

/*
 * Permission Functions
 */
/**
 * @param $node
 * @return mixed
 */
function node_id($node) {
    return value("nodes", "id", " WHERE node_name = '".StringFormatter::clean_input($node)."'");
}

/**
 * @param $id
 * @return mixed
 */
function node_name($id) {
    return value("nodes", "node_name", " WHERE id = '".StringFormatter::clean_input($id)."'");
}

/**
 * @param $id
 * @return mixed
 */
function node_details($id) {
    global $pdo, $prefix;
    $t = $prefix."_nodes";
    $stmt = $pdo->prepare("SELECT node_name, node_description FROM `".$t."` WHERE id = ?");
    $stmt->execute(array($id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * @param $node
 * @param $description
 */
function node_add($node, $description) {
    global $pdo, $prefix;
    $t = $prefix."_nodes";
    $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, node_name, node_description) VALUES('', ?, ?)");
    $stmt->execute(array($node, $description));
}

/**
 * @param $id
 * @param $node
 * @param $description
 */
function node_edit($id, $node, $description) {
    global $pdo, $prefix;
    $t = $prefix."_nodes";
    $stmt = $pdo->prepare("UPDATE `".$t."` SET node_name = ?, node_description = ? WHERE id = ?");
    $stmt->execute(array($node, $description, $id));
}

/**
 * @param $id
 */
function node_delete($id) {
    global $pdo, $prefix;
    $t = $prefix."_nodes";
    $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
    $stmt->execute(array($id));
}

/*
 * Session Functions
 */

/**
 * @param string $identifier
 */
function check_session($identifier) {
    if($identifier === null) { return false; }
    return isset($_SESSION[$identifier]);
}

/**
 * @param $identifier
 */
function destroy_session($identifier) {
    if($identifier === null) { return; }
    if(isset($_SESSION[$identifier])) {
        unset($_SESSION[$identifier]);
    }
}

/**
 *
 */
function destroy_entire_session() {
    session_destroy();
}

/*
 * Hashing/Generation Functions
 */
/**
 * @param int $length
 * @return string
 */
function generate_salt($length = 25) {
    return substr(md5(generate_uuid()), 0, $length);
}

/**
 * @param $value
 * @param bool $useSalt
 * @param string $salt
 * @return string
 */
function generate_hash($value, $useSalt = false, $salt = "") {
    if($useSalt) {
        if(trim($salt) != "" && strlen(trim($salt)) == 25) {
            return hash('sha256', $salt.$value);
        }
    }
    return hash('sha256', $value);
}

/**
 * @param $hash
 * @param $value
 * @return bool
 */
function check_hash($hash, $value) {
    return $hash == hash('sha256', $value);
}

//Thanks to this comment: http://php.net/manual/en/function.uniqid.php#94959
/**
 * @return string
 */
function generate_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

/**
 * @param int $length
 * @return string
 */
function generate_session_id($length = 35) {
    return substr(md5(generate_salt(30).generate_uuid()), 0, $length);
}