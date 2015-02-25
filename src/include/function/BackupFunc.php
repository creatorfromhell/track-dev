<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 1/11/14 at 5:20 PM
 * Last Modified by Daniel Vidmar.
 */
class BackupFunc {

    /**
     * @var string
     */
    public static $directory = "resources/backup/";
	
	/*
	 * Backup all logged activities
	 */
    /**
     * @param $format
     */
    public static function backup_activities($format) {
        if($format == "xml") {
            self::backup_activities_XML();
        } else if($format == "csv") {
            self::backup_activities_CSV();
        } else {
            self::backup_activities_PT();
        }
	}
	
	/*
     * Create an XML backup of all activities
     */
    /**
     *
     */
    private static function backup_activities_XML() {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("SELECT id, username, project, list, activity_type, activity_parameters, archived, logged FROM `".$t."`");
        $stmt->execute();

        $file_name = self::directory."activity-backup-".date("Y-m-d").".xml";
        $file = fopen($file_name, "w");
        fwrite($file, "<activities>\n");
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "<activity>\n");
            fwrite($file, "<id>".$result['id']."</id>\n");
            fwrite($file, "<user>".$result['username']."</user>\n");
            fwrite($file, "<date>".$result['logged']."</date>\n");
            fwrite($file, "<archived>".$result['archived']."</archived>\n");
            fwrite($file, "<project>".$result['project']."</project>\n");
            fwrite($file, "<list>".$result['list']."</list>\n");
            fwrite($file, "<type>".$result['activity_type']."</type>\n");
            fwrite($file, "<parameters>".$result['activity_parameters']."</parameters>\n");
            fwrite($file, "</activity>\n");
        }
        fwrite($file, "<generated>".date("Y-m-d at H:i:s")."</generated>");
        fwrite($file, "</activities>");
        fclose($file);
    }

    /*
     * Create a CSV backup of all activities
     */
    /**
     *
     */
    private static function backup_activities_CSV() {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("SELECT id, username, project, list, activity_type, activity_parameters, archived, logged FROM `".$t."`");
        $stmt->execute();

        $file_name = self::directory."activity-backup-".date("Y-m-d").".csv";
        $file = fopen($file_name, "w");
        fwrite($file, "id,user,date,archived,project,list,type,parameters");
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "\n".$result['id'].",".$result['username'].",".$result['logged'].",".$result['archived'].",".$result['project'].",".$result['list'].",".$result['activity_type'].",".$result['activity_parameters']);
        }
        fclose($file);
    }

    /*
     * Create a plain text backup of all activities
     */
    /**
     *
     */
    private static function backup_activities_PT() {
        global $prefix, $pdo;
        $t = $prefix."_activity";
        $stmt = $pdo->prepare("SELECT id, username, project, list, activity_type, activity_parameters, archived, logged FROM `".$t."`");
        $stmt->execute();

        $file_name = self::directory."activity-backup-".date("Y-m-d").".txt";
        $file = fopen($file_name, "w");
        fwrite($file, "Trackr Activity Generator\n");
        fwrite($file, "Generated: ".date("Y-m-d at H:i:s"));
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fwrite($file, "\n\nActivity");
            fwrite($file, "\nID: ".$result['id']);
            fwrite($file, "\nUser: ".$result['username']);
            fwrite($file, "\nDate: ".$result['logged']);
            fwrite($file, "\nArchived: ".$result['archived']);
            fwrite($file, "\nProject: ".$result['project']);
            fwrite($file, "\nList: ".$result['list']);
            fwrite($file, "\nType: ".$result['activity_type']);
            fwrite($file, "\nParameters: ".$result['activity_parameters']);
        }
        fclose($file);
    }

}