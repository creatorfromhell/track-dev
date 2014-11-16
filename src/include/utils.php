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
function cleanInput($input) {
    return strip_tags(trim($input));
}

function validUsername($value) {
    return preg_match('/^[a-zA-Z0-9_.-]+$/i', $value);
}

function validEmail($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function checkCaptcha($value) {
    if($value === null) { return false; }
    if(!isset($_SESSION['userspluscaptcha'])) {
        return false;
    }
    return $_SESSION['userspluscaptcha'] == $value;
}

function strContains($string, $word) {
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
function setValue($table, $column, $value, $extra = '') {
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
    $result = $stmt->fetchAll();

    $values = array();
    foreach($result as &$r) {
        $values[] = $r;
    }
    return $values;
}

/**
 * @param string $table
 */
function hasValues($table, $extra = '') {
    if(countColumns($table, $extra) > 0) {
        return true;
    }
    return false;
}

/**
 * @param string $table
 */
function countColumns($table, $extra = '') {
    global $prefix, $pdo;
    $t = $prefix."_".$table;
    $stmt = $pdo->prepare("SELECT * FROM `".$t."`".$extra);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_NUM);
}

function toOptions($data, $value = null) {
    $return = '';
    $options = $data;
    foreach($options as &$option) {
        $return .= '<option value="'.$option.'"'.(($value !== null && $value == $option) ? ' selected' : '').'>'.$option.'</option>';
    }
    return $return;
}

function uploadFile($file, $name, $maxSize = 1000000) {
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
function isAdmin() {
    if(isset($_SESSION['usersplusprofile']) && User::exists($_SESSION['usersplusprofile']) && User::load($_SESSION['usersplusprofile'])->isAdmin()) { return true; }
    return false;
}

function getName() {
    if(isset($_SESSION['usersplusprofile']) && User::exists($_SESSION['usersplusprofile'])) { return $_SESSION['usersplusprofile']; }
    return "Guest(".User::getIP().")";
}

function latestUsers() {
    //new method values("users", "user_name", " ORDER BY user_registered DESC LIMIT 7");
}

function userNav() {
    $out = '';
    $out .= '<nav class="userNav">';
    $out .= '<ul><li><a href="#">'.getName().'</a>';
    $out .= '<ul>';
    if(isAdmin()) {
        $out .= '<li><a href="admin.php">Admin</a></li>';
    }
    $out .= '<li><a href="logout.php">Logout</a></li>';
    $out .= '</ul></ul></nav>';
    return $out;
}

function canViewList($id) {
    $viewPermission = ListFunc::viewPermission($id);
    if(ListFunc::guestView($id)) { return true; }
    if(!isset($_SESSION['usersplusprofile']) || !User::exists($_SESSION['usersplusprofile'])) { return false; }
    if(isAdmin()) { return true; }
    if(ProjectFunc::getOverseer(ListFunc::getProject($id)) == getName() || ListFunc::getOverseer($id) == getName()) { return true; }
	$user = User::load($_SESSION['usersplusprofile']);
    if($viewPermission != "none" && hasValues("nodes", " WHERE id = '".cleanInput($viewPermission)."'") && $user->hasPermission($viewPermission)) { return true; }
    return false;
}

function canEditList($id) {
    $editPermission = ListFunc::editPermission($id);
    if(ListFunc::guestEdit($id)) { return true; }
    if(!isset($_SESSION['usersplusprofile']) || !User::exists($_SESSION['usersplusprofile'])) { return false; }
    if(isAdmin()) { return true; }
    if(ProjectFunc::getOverseer(ListFunc::getProject($id)) == getName() || ListFunc::getOverseer($id) == getName()) { return true; }
    $user = User::load($_SESSION['usersplusprofile']);
	if($editPermission != "none" && hasValues("nodes", " WHERE id = '".cleanInput($editPermission)."'") && $user->hasPermission($editPermission)) { return true; }
    return false;
}

function canEditTask($listID, $taskID) {
    $editPermission = ListFunc::editPermission($listID);
    if(ListFunc::guestEdit($listID)) { return true; }
    if(!isset($_SESSION['usersplusprofile']) || !User::exists($_SESSION['usersplusprofile'])) { return false; }
    if(isAdmin()) { return true; }
    if(ProjectFunc::getOverseer(ListFunc::getProject($listID)) == getName() || ListFunc::getOverseer($listID) == getName()) { return true; }
    $details = TaskFunc::taskDetails(ListFunc::getProject($listID), ListFunc::getName($listID), $taskID);
    if($details['author'] == getName()) { return true; }
	$user = User::load($_SESSION['usersplusprofile']);
    if($editPermission != "none" && hasValues("nodes", " WHERE id = '".cleanInput($editPermission)."'") && $user->hasPermission($editPermission) && $details['editable'] == '1') { return true; }
    return false;
}

function loggedIn() {
    return (checkSession("usersplusprofile"));
}

/*
 * Page Functions
 */
function pageLocked($user, $node = "", $guest = false, $admin = false, $group = "", $useGroup = false, $name = "", $useName = false) {
    if($useGroup) { return pageLockedGroup($user, $group); }
    if($useName) { return pageLockedUser($user, $name); }
    if($admin) { return pageLockedAdmin($user); }
    return pageLockedNode($user, $node, $guest);
}

/**
 * @param string $node
 */
function pageLockedNode($user, $node, $guest = false) {
    if($guest) { return false; }
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->isAdmin()) { return false; }
    if(!hasValues("nodes", " WHERE node_name = '".cleanInput($node)."'")) { return true; }
    if($user->hasPermission(nodeID($node))) { return false; }
    if($user->group->hasPermission(nodeID($node))) { return false; }
    return true;
}

function pageLockedAdmin($user) {
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->isAdmin()) { return false; }
    return true;
}

/**
 * @param string $group
 */
function pageLockedGroup($user, $group) {
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->isAdmin()) { return false; }
    if($user->group->id == $group) { return false; }
    return true;
}

/**
 * @param string $name
 */
function pageLockedUser($user, $name) {
    if($user === null) { return true; }
    if(!is_a($user, "User")) { return true; }
    if($user->isAdmin()) { return false; }
    if($user->name == $name) { return false; }
    return true;
}

/*
 * Permission Functions
 */
function nodeID($node) {
    return value("nodes", "id", " WHERE node_name = '".cleanInput($node)."'");
}

function nodeName($id) {
    return value("nodes", "node_name", " WHERE id = '".cleanInput($id)."'");
}

function nodeDetails($id) {
    global $pdo, $prefix;
    $t = $prefix."_nodes";
    $stmt = $pdo->prepare("SELECT node_name, node_description FROM `".$t."` WHERE id = ?");
    $stmt->execute(array($id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function nodeAdd($node, $description) {
    global $pdo, $prefix;
    $t = $prefix."_nodes";
    $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, node_name, node_description) VALUES('', ?, ?)");
    $stmt->execute(array($node, $description));
}

function nodeEdit($id, $node, $description) {
    global $pdo, $prefix;
    $t = $prefix."_nodes";
    $stmt = $pdo->prepare("UPDATE `".$t."` SET node_name = ?, node_description = ? WHERE id = ?");
    $stmt->execute(array($node, $description, $id));
}

function nodeDelete($id) {
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
function checkSession($identifier) {
    if($identifier === null) { return false; }
    return isset($_SESSION[$identifier]);
}

function destroySession($identifier) {
    if($identifier === null) { return; }
    if(isset($_SESSION[$identifier])) {
        unset($_SESSION[$identifier]);
    }
}

function destroyEntireSession() {
    session_destroy();
}

/*
 * Hashing/Generation Functions
 */
function generateSalt($length = 25) {
    return substr(md5(generateUUID()), 0, $length);
}

function generateHash($value, $useSalt = false, $salt = "") {
    if($useSalt) {
        if(trim($salt) != "" && strlen(trim($salt)) == 25) {
            return hash('sha256', $salt.$value);
        }
    }
    return hash('sha256', $value);
}

function checkHash($hash, $value) {
    return $hash == hash('sha256', $value);
}

//Thanks to this comment: http://php.net/manual/en/function.uniqid.php#94959
function generateUUID() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

function generateSessionID($length = 35) {
    return substr(md5(generateSalt(30).generateUUID()), 0, $length);
}
?>