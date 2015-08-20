<?php
/**
 * Created by creatorfromhell.
 * Date: 7/6/15
 * Time: 2:13 PM
 * Version: Beta 2
 * An executions file for PHPWAW modified for Trackr.
 */

class Executions extends ExecutionsCore {

    public static function unpack($from, $to) {
        $archive = new ZipArchive();
        $archive->open($from);
        $archive->extractTo($to);
        $archive->close();
        unlink($from);
    }

    public static function create_configurations() {
        $contents = array(
            ";Trackr Configuration File",
            ";Do not edit the following values",
            "[trackr]",
            "version = Beta 2",
            ";Edit the following values accordingly",
            "[main]",
            "registration = true",
            "email_activation = false",
            "theme = Default",
            "language = ".$_SESSION['values']['language'],
            "dateformat = Y-M-D",
            "blacklist =",
            "[file]",
            ";File size in megabytes",
            "max_upload = 3",
            "upload_directory = resources/uploads",
            "backup_directory = resources/backup",
            "allowed_types = zip,rar,gzip",
            "[email]",
            "replyemail = ".$_SESSION['values']['email_reply'],
            "[database]",
            "db_username = ".$_SESSION['values']['db_username'],
            "db_password = ".$_SESSION['values']['db_password'],
            "db_host = ".$_SESSION['values']['db_host'],
            "db_name = ".$_SESSION['values']['db_name'],
            "db_prefix = ".$_SESSION['values']['sql_prefix'],
            "[urls]",
            "base_url = ".$_SESSION['values']['url_base'],
            "installation_path = ".$_SESSION['values']['url_path'],
        );
        file_put_contents("../resources/config.ini", implode(PHP_EOL, $contents), LOCK_EX);
    }

    public static function complete() {
        header("LOCATION: ../installed.php");
    }
}