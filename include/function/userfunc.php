<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 12/13/13 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

require_once("include/function/groupfunc.php");
require_once("include/function/listfunc.php");
require_once("include/utils.php");
require_once("include/connect.php");
require_once("include/config.php");
class UserFunc {

    //add
    public static function add($username, $password, $usergroup, $registered, $lastlogin, $ip, $email, $activationKey) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, username, password, usergroup, registered, lastlogin, ip, email, banned, online, activated, activationkey) VALUES ('', ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, ?)");
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
        $stmt = $c->prepare("UPDATE `".$t."` SET password = ?, usergroup = ?, registered = ?, lastlogin = ? ip = ?, email = ?, banned = ?, online = ?, activated = ?, activationkey = ? WHERE username = ?");
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
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
    }

    //rename
    public static function rename($username, $new) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE `".$t."` SET username = ? WHERE username = ?");
        $stmt->bindParam(1, $new);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //exists
    public static function exists($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT id FROM `".$t."` WHERE username = ?");
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
        $stmt = $c->prepare("UPDATE `".$t."` SET lastlogin = ? WHERE username = ?");
        $stmt->bindParam(1, $lastlogin);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //isAdmin
    public static function isAdmin($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $userTable = $connect->prefix."_users";
        $groupTable = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT admin FROM ".$groupTable." WHERE id = (SELECT usergroup FROM ".$userTable." WHERE username = ?)");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result['admin'] == '1') {
            return true;
        }
        return false;
    }

    public static function getPermission($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $userTable = $connect->prefix."_users";
        $groupTable = $connect->prefix."_groups";
        $stmt = $c->prepare("SELECT permission FROM ".$groupTable." WHERE id = (SELECT usergroup FROM ".$userTable." WHERE username = ?)");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['permission'];
    }

    public static function getEmail($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT email FROM `".$t."` WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['email'];
    }

    //can edit
    public static function canEdit($project, $list, $username) {
        if(self::exists($username)) {
            return self::hasPermission($username, ListFunc::editPermission($project, $list));
        }
        return (ListFunc::guestEdit($project, $list));
    }

    //can view
    public static function canView($project, $list, $username) {
        if(self::exists($username)) {
            return self::hasPermission($username, ListFunc::viewPermission($project, $list));
        }
        return (ListFunc::guestView($project, $list));
    }

    //has permission
    public static function hasPermission($username, $permission) {
        return (self::getPermission($username) >= $permission);
    }

    //get group
    public static function getGroup($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT usergroup FROM `".$t."` WHERE username = ?");
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
        $stmt = $c->prepare("UPDATE `".$t."` SET usergroup = ? WHERE username = ?");
        $stmt->bindParam(1, $group);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //validate password
    public static function validatePassword($username, $password) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT password FROM `".$t."` WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['password'] === self::hashPass($password)) {
            return true;
        }
        return false;
    }

    //send verification
    public static function sendVerification($username) {
        $config = new Configuration();

        $email = self::getEmail($username);
        $key = self::getActivationKey($username);

        $subject = $config->config["email"]["subject"];
        $message = "";

        $adminEmail = $config->config["email"]["replyemail"];
        $headers = 'From: '.$adminEmail."\r\n" . 'Reply-To: '.$adminEmail . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers);
    }

    //change status
    public static function changeStatus($username) {
        $status = (self::loggedIn($username)) ? "0" : "1";
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE `".$t."` SET online = ? WHERE username = ?");
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //is logged in
    public static function loggedIn($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT online FROM `".$t."` WHERE username = ?");
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
        $stmt = $c->prepare("SELECT activated FROM `".$t."` WHERE username = ?");
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
        $stmt = $c->prepare("UPDATE `".$t."` SET activated = 0 WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
    }

    public static function getActivationKey($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT activationkey FROM `".$t."` WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['activationkey'];
    }

    public static function setActivationKey($username, $key) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE `".$t."` SET activationkey = ? WHERE username = ?");
        $stmt->bindParam(1, $key);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    //generate activation key
    public static function generateActivationKey() {
        return Utils::generateUUID();
    }

    public static function printUserNav($username) {
        $out = '';
        $out .= '<nav class="userNav">';
        $out .= '<ul>';
        $out .= '<li><a href="#">'.$username.'</a>';
        $out .= '<ul>';
        if(self::isAdmin($username)) {
            $out .= '<li><a href="admin.php">Admin</a></li>';
        }
        $out .= '<li><a href="logout.php">Logout</a></li>';
        $out .= '</ul>';
        $out .= '</ul>';
        $out .= '</nav>';
        return $out;
    }

    //ban
    public static function ban($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE `".$t."` SET banned = 1 WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
    }

    //unban
    public static function unban($username) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("UPDATE `".$t."` SET banned = 0 WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
    }

    public static function users() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT username from ".$t);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $users = array();
        for($i = 0; $i < count($result); $i++) {
            $user = $result[$i];
            $users[$i] = $user[0];
        }

        return $users;
    }

    public static function latestUsers() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT username from `".$t."` ORDER BY registered DESC LIMIT 7");
        $stmt->execute();
        $result = $stmt->fetchAll();

        $users = array();
        for($i = 0; $i < count($result); $i++) {
            $user = $result[$i];
            $users[$i] = $user[0];
        }

        return $users;
    }

    public static function printUsers($username, $formatter) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_users";
        $stmt = $c->prepare("SELECT id, username, usergroup, email, registered FROM ".$t);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['username'];
            $group = $row['usergroup'];
            $email = $row['email'];
            $registered = $row['registered'];

            echo "<tr>";
            echo "<td class='name'>".$name."</td>";
            echo "<td class='email'>".$email."</td>";
            echo "<td class='group'>".GroupFunc::getName($group)."</td>";
            echo "<td class='registered'>".$formatter->formatDate($registered)."</td>";
            echo "<td class='actions'>";

            if(self::isAdmin($username)) {
                echo "<a title='Edit' class='actionEdit' onclick='editTask(); return false;'></a>";
                echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?t=users&action=delete&id=".$id."'></a>";
            } else {
                echo $formatter->replace("%none");
            }

            echo "</td>";
            echo "</tr>";
        }
    }

    public static function printEditForm($id) {
        //TODO: print edit form
    }
}
?>