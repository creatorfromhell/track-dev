<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/11/14 at 5:20 PM
 * Last Modified by Daniel Vidmar.
 */

//Include the Connect Class
require_once("include/connect.php");
require_once("include/function/userfunc.php");
class ActivityFunc {

    //log activity
    public static function log($username, $project, $list, $activitytype, $parameters, $archived, $logged) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, username, project, list, activitytype, parameters, archived, logged) VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $list);
        $stmt->bindParam(4, $activitytype);
        $stmt->bindParam(5, $parameters);
        $stmt->bindParam(6, $archived);
        $stmt->bindParam(7, $logged);
        $stmt->execute();
    }

    public static function printActivities($username, $formatter) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("SELECT id, archived, logged FROM `".$t."`");
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $description = self::getReadableActivity($id, $formatter->languageinstance);
            $archived = ($row['archived'] == 1) ? (string)$formatter->languageinstance->site->tables->yes : (string)$formatter->languageinstance->site->tables->no;
            $logged = $row['logged'];

            echo "<tr>";
            echo "<td class='description'>".$description."</td>";
            echo "<td class='archived'>".$archived."</td>";
            echo "<td class='logged'>".$logged."</td>";
            echo "<td class='actions'>";

            if(UserFunc::isAdmin($username)) {
                echo "<a title='Edit' class='actionEdit'></a>";
                echo "<a title='Delete' class='actionDelete' onclick='return confirm(\"Are you sure?\");' href='?t=activity&action=delete&id=".$id."'></a>";
            } else {
                echo $formatter->replace("%none");
            }

            echo "</td>";
            echo "</tr>";
        }
    }

    public static function parseType($id, $language) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("SELECT activitytype FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //Example Type: user:login
        $type = explode(":", $result['activitytype']);

        $value = $language->xpath("site/activities/".$type[0]."/".$type[1])[0];
        return (string)($value);
    }

    //get readable activity
    public static function getReadableActivity($id, $language) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("SELECT username, project, list, parameters, archived, logged FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $replace = array("%user", "%project", "%list", "%logged");
        $replacements = array($result['username'], $result['project'], $result['list'], $result['logged']);
        $description = self::parseType($id, $language);

        if(trim($result['parameters']) != '') {
            $parameters = explode(',', $result['parameters']);

            foreach($parameters as &$param) {
                $pars = explode(':', $param);
                $description = str_ireplace("%".$pars[0], $pars[1], $description);
            }
        }

        $activity = str_ireplace($replace, $replacements, $description);
        return $activity;
    }

    //archive log
    public static function archive($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("UPDATE `".$t."` SET archived = 1 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //unarchive log
    public static function unarchive($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("UPDATE `".$t."` SET archived = 0 WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public static function delete($id) {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    //clean logs
    public static function clean() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("DELETE FROM `".$t."` WHERE logged < DATE_SUB(CURDATE(), INTERVAL 5 DAY)");
        $stmt->execute();
    }

    //backup logs
    public static function backup($format) {
        if($format == "xml") {
            self::backupXML();
        } else if($format == "csv") {
            self::backupCSV();
        } else {
            self::backupPT();
        }
    }

    /*
     * Create a XML backup
     */
    private static function backupXML() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("SELECT id, user, project, list, activitytype, parameters, archived, logged FROM ".$t);
        $stmt->execute();

        $fileName = "activity-backup-".date("Y-m-d").".xml";
        $file = fopen($fileName, "w");
        fwrite($file, "<activities>\n");
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "<activity>\n");
            fwrite($file, "<id>".$result['id']."</id>\n");
            fwrite($file, "<user>".$result['user']."</user>\n");
            fwrite($file, "<date>".$result['logged']."</date>\n");
            fwrite($file, "<archived>".$result['archived']."</archived>\n");
            fwrite($file, "<project>".$result['project']."</project>\n");
            fwrite($file, "<list>".$result['list']."</list>\n");
            fwrite($file, "<type>".$result['activitytype']."</type>\n");
            fwrite($file, "<parameters>".$result['parameters']."</parameters>\n");
            fwrite($file, "</activity>\n");
        }
        fwrite($file, "<generated>".date("Y-m-d at H:i:s")."</generated>");
        fwrite($file, "</activities>");
        fclose($file);
    }

    /*
     * Create a CSV backup
     */
    private static function backupCSV() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("SELECT * FROM ".$t);
        $stmt->execute();

        $fileName = "activity-backup-".date("Y-m-d").".csv";
        $file = fopen($fileName, "w");
        fwrite($file, "id,user,date,archived,project,list,type,parameters");
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "\n".$result['id'].",".$result['user'].",".$result['logged'].",".$result['archived'].",".$result['project'].",".$result['list'].",".$result['activitytype'].",".$result['parameters']);
        }
        fclose($file);
    }

    /*
     * Create a plain text backup
     */
    private static function backupPT() {
        $connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("SELECT * FROM ".$t);
        $stmt->execute();

        $fileName = "activity-backup-".date("Y-m-d").".txt";
        $file = fopen($fileName, "w");
        fwrite($file, "Trackr Activity Generator\n");
        fwrite($file, "Generated: ".date("Y-m-d at H:i:s"));
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "\n\nActivity");
            fwrite($file, "\nID: ".$result['id']);
            fwrite($file, "\nUser: ".$result['user']);
            fwrite($file, "\nDate: ".$result['logged']);
            fwrite($file, "\nArchived: ".$result['archived']);
            fwrite($file, "\nProject: ".$result['project']);
            fwrite($file, "\nList: ".$result['list']);
            fwrite($file, "\nType: ".$result['activitytype']);
            fwrite($file, "\nParameters: ".$result['parameters']);
        }
        fclose($file);
    }
}
?>