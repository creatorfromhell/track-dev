<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 10:48 AM
 * Version: Beta 1
 * Last Modified: 8/9/14 at 3:09 AM
 * Last Modified by Daniel Vidmar.
 */
require_once('group.php');
class User {
    public $id = null;
    public $ip = null;
    public $avatar = "";
    public $name = null;
    public $password = null;
    public $group = null;
    public $permissions = array();
    public $email = null;
    public $registered = null;
    public $loggedIn = null;
    public $activationKey = null;
    public $activated = 0;
    public $banned = 0;
    public $online = 0;

    public function hasPermission($id) {
        foreach($this->permissions as &$perm) {
            if($perm == $id) {
                return true;
            }
        }

        return $this->group->hasPermission($id);
    }

    public function isAdmin() {
        return $this->group->isAdmin();
    }

    public function save() {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $perm = implode(",", $this->permissions);
        $stmt = $pdo->prepare("UPDATE `".$t."` SET user_name = ?, user_password = ?, user_email = ?, user_group = ?, user_permissions = ?, user_avatar = ?, user_ip = ?, user_registered = ?, logged_in = ?, user_banned = ?, user_online = ?, user_activated = ?, activation_key = ? WHERE id = ?");
        $stmt->execute(array($this->id, $this->name, $this->password, $this->email, $this->group->id, $perm, $this->avatar, $this->ip, $this->registered, $this->loggedIn, $this->banned, $this->online, $this->activated, $this->activationKey, $this->id));
    }

    public function sendActivation() {
        global $url, $admin_email;
        $headers = 'From: '.$admin_email."\r\n" . 'Reply-To: '.$admin_email . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        mail($this->email, "Account Activation", "Hello ".$this->name.",\r\n You or someone using your email has registered on ".$url.". Please click the following link if you registered on this site, ".$url."/activation.php?page=activate&name=".$this->name."&key=".$this->activationKey.".", $headers);
    }

    public static function load($name, $email = false, $id = false) {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $query = "SELECT id, user_password, user_email, user_group, user_permissions, user_avatar, user_ip, user_registered, logged_in, user_banned, user_online, user_activated, activation_key FROM `".$t."` WHERE user_name = ?";
        //$query = ($email) ? "SELECT id, user_password, user_name, user_group, user_permissions, user_avatar, user_ip, user_registered, logged_in, user_banned, user_online, user_activated, activation_key FROM `".$t."` WHERE user_email = ?" : "SELECT id, user_password, user_email, user_group, user_permissions, user_avatar, user_ip, user_registered, logged_in, user_banned, user_online, user_activated, activation_key FROM `".$t."` WHERE user_name = ?";
        if($email) {
            $query = "SELECT id, user_password, user_name, user_group, user_permissions, user_avatar, user_ip, user_registered, logged_in, user_banned, user_online, user_activated, activation_key FROM `".$t."` WHERE user_email = ?";
        }
        if($id) {
            $query = "SELECT user_password, user_email, user_name, user_group, user_permissions, user_avatar, user_ip, user_registered, logged_in, user_banned, user_online, user_activated, activation_key FROM `".$t."` WHERE id = ?";
        }

        $user = new User();
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($name));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user->id = ($id) ? $name : $result['id'];
        $user->ip = $result['user_ip'];
        $user->avatar = $result['user_avatar'];
        $user->name = ($email) ? $result['user_name'] : ($id) ? $result['user_name'] : $name;
        $user->password = $result['user_password'];
        $user->group = Group::load($result['user_group']);
        $user->permissions = explode(",", $result['user_permissions']);
        $user->email = ($email) ? $name : $result['user_email'];
        $user->registered = $result['user_registered'];
        $user->loggedIn = $result['logged_in'];
        $user->activationKey = $result['activation_key'];
        $user->activated = $result['user_activated'];
        $user->banned = $result['user_banned'];
        $user->online = $result['user_online'];
        return $user;
    }

    public static function exists($name, $email = false) {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $query = ($email) ? "SELECT id FROM `".$t."` WHERE user_email = ?" : "SELECT id FROM `".$t."` WHERE user_name = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($name));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
    }

    public static function getName($id) {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $stmt = $pdo->prepare("SELECT user_name FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['user_name'];
    }

    public static function getAvailableID() {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `".$t."`");
        $stmt->execute();
        $id = $stmt->fetchColumn();
        $id++;
        return $id;
    }

    public static function getHashedPassword($name, $email = false) {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $query = ($email) ? "SELECT user_password FROM `".$t."` WHERE user_email = ?" : "SELECT user_password FROM `".$t."` WHERE user_name = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($name));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['user_password'];
    }

    public static function addUser($user) {
        if(!is_a($user, "User")) { return; }
        global $pdo, $prefix;
        $t = $prefix."_users";
        $perm = implode(",", $user->permissions);
        $stmt = $pdo->prepare("INSERT INTO `".$t."` (id, user_name, user_password, user_email, user_group, user_permissions, user_avatar, user_ip, user_registered, logged_in, user_banned, user_online, user_activated, activation_key) VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($user->id, $user->name, $user->password, $user->email, $user->group->id, $perm, $user->avatar, $user->ip, $user->registered, $user->loggedIn, $user->banned, $user->online, $user->activated, $user->activationKey));
    }

    public static function delete($id) {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $stmt = $pdo->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
    }

    public static function validID($id) {
        global $pdo, $prefix;
        $t = $prefix."_users";
        $stmt = $pdo->prepare("SELECT user_name FROM `".$t."` WHERE id = ?");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
    }

    public static function getIP() {
        $ip = "";
        if (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"]." ";
        } else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]." ";
        } else if ( isset($_SERVER["HTTP_CLIENT_IP"]) ) {
            $ip = $_SERVER["HTTP_CLIENT_IP"]." ";
        }
        return $ip;
    }
}
?>