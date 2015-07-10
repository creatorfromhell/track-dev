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
        //TODO: Create this
    }

    public static function complete() {
        header("LOCATION: ../installed.php");
    }
}