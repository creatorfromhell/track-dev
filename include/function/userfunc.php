<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 12/13/13 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

require_once("groupfunc.php");
require_once("../utils.php");
require_once("../connect.php");
class UserFunc {

    //add
    public static function add($username, $password, $usergroup, $registered, $lastlogin, $ip, $email, $activationKey) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("INSERT INTO ".$t." (id, username, password, usergroup, registered, lastlogin, ip, email, banned, online, activated, activationkey) VALUES ('', ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, ?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        $stmt->bindParam(3, $usergroup);
        $stmt->bindParam(4, $registered);
        $stmt->bindParam(5, $lastlogin);
        $stmt->bindParam(6, $ip);
        $stmt->bindParam(7, $email);
        $stmt->bindParam(8, $activationKey);
        $stmt->execute();
    }

    //edit
    public static function edit($username, $password, $usergroup, $registered, $lastlogin, $ip, $email, $activationKey) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET password = ?, usergroup = ?, registered = ?, lastlogin = ? ip = ?, email = ?, banned = ?, online = ?, activated = ?, activationkey = ? WHERE username = ?");
        $stmt->bindParam(1, $password);
        $stmt->bindParam(2, $usergroup);
        $stmt->bindParam(3, $registered);
        $stmt->bindParam(4, $lastlogin);
        $stmt->bindParam(5, $ip);
        $stmt->bindParam(6, $email);
        $stmt->bindParam(7, $activationKey);
        $stmt->bindParam(8, $username);
        $stmt->execute();
    }

    //delete
    public static function delete($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("DELETE FROM ".$t." WHERE username = ?");
        $stmt->bind_param(1, $username);
        $stmt->execute();
    }

    //rename
    public static function rename($username, $new) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET username = ? WHERE username = ?");
        $stmt->bindParam(1, $new);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //exists
    public static function exists($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT id FROM ".$t." WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return true;
        }
        return false;
    }

    //Hash password
    public static function hashPass($password) {
        return hash( 'sha256', $password );
    }

    //update the user's lastlogin date
    public static function updateLoginDate($username) {
        $lastlogin = date("Y-m-d H:i:s");

        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET lastlogin = ? WHERE username = ?");
        $stmt->bindParam(1, $lastlogin);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //isAdmin
    public static function isAdmin($username) {
        return GroupFunc::isAdmin(UserFunc::getGroup($username));
    }

    //get group
    public static function getGroup($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT usergroup FROM ".$t." WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['usergroup'];
    }

    //set group
    public static function setGroup($username, $group) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET usergroup = ? WHERE username = ?");
        $stmt->bindParam(1, $group);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //validate password
    public static function validatePassword($username, $password) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT password FROM ".$t." WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['password'] == self::hashPass($password)) {
            return true;
        }
        return false;
    }

    //send verification
    public static function sendVerification($email, $activationKey) {
        //TODO: Add verification email stuff.
    }

    //change status
    public static function changeStatus($username) {
        $status = (loggedIn($username)) ? "0" : "1";
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET online = ? WHERE username = ?");
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //is logged in
    public static function loggedIn($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT online FROM ".$t." WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $online = $result['online'];

        if($online == 1) {
            return true;
        }
        return false;
    }

    //activated
    public static function activated($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT activated FROM ".$t." WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $activated = $result['activated'];

        if($activated == 1) {
            return true;
        }
        return false;
    }

    //activate
    public static function activate($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET activated = 0 WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
    }

    //generate activation key
    public static function generateActivationKey() {
        return Utils::generateUUID();
    }

    //ban
    public static function ban($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET banned = 1 WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
    }

    //unban
    public static function unban($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE ".$t." SET banned = 0 WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
    }
}
?>