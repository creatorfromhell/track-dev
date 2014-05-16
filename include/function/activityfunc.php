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
class ActivityFunc {

    //log activity
    public static function log($user, $project, $list, $description, $archived, $logged) {
		$connect = new Connect();
        $c = $connect->connection;
        $t = $connect->prefix."_activity";
        $stmt = $c->prepare("INSERT INTO `".$t."` (id, user, project, list, description, archived, logged) VALUES ('', ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $user);
        $stmt->bindParam(2, $project);
        $stmt->bindParam(3, $list);
        $stmt->bindParam(4, $description);
        $stmt->bindParam(5, $archived);
        $stmt->bindParam(6, $logged);
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
        //TODO: Make function to backup logs to some format(XML, CSV, etc) or maybe configurable format?
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
        $stmt = $c->prepare("SELECT * FROM ".$t);
        $stmt->execute();

        $fileName = "activity-backup-".date("Y-m-d").".xml";
        $file = fopen($fileName, "w");
        fwrite($file, "<activities>\n");
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "<activity>\n");
            fwrite($file, "<id>".$result['id']."</id>\n");
            fwrite($file, "<user>".$result['user']."</user>\n");
            fwrite($file, "<date>".$result['logged']."</date>\n");
            fwrite($file, "<project>".$result['project']."</project>\n");
            fwrite($file, "<list>".$result['list']."</list>\n");
            fwrite($file, "<description>".$result['description']."</description>\n");
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
        fwrite($file, "id,user,date,project,list,description");
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "\n".$result['id'].",".$result['user'].",".$result['logged'].",".$result['project'].",".$result['list'].",".$result['description']);
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
            fwrite($file, "\nProject: ".$result['project']);
            fwrite($file, "\nList: ".$result['list']);
            fwrite($file, "\nDescription: ".$result['description']);
        }
        fclose($file);
    }
}
?>