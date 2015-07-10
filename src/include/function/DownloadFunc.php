<?php
/**
 * Created by Daniel Vidmar.
 * Date: 10/18/14
 * Time: 1:04 AM
 * Version: Beta 2
 * Last Modified: 10/18/14 at 1:04 AM
 * Last Modified by Daniel Vidmar.
 */
class DownloadFunc {
    //add_download($project_id, $version_id, $file_name)
    public static function add_download($project_id, $version_id, $file_name) {
        global $prefix, $pdo;
        $t = $prefix."_downloads";
        $stmt = $pdo->prepare("INSERT INTO ".$t." (id, project_id, version_id, file_name, file_downloads) VALUES('', ?, ?, ?, ?)");
        $stmt->execute(array($project_id, $version_id, $file_name, "0"));
    }

    //edit_download($id, $project_id, $version_id, $file_name)
    public static function edit_download($id, $project_id, $version_id, $file_name) {
        global $prefix, $pdo;
        $t = $prefix."_downloads";
        $stmt = $pdo->prepare("UPDATE ".$t." SET project_id = ?, version_id = ? file_name = ? WHERE id = ?");
        $stmt->execute(array($project_id, $version_id, $file_name, $id));
    }

    //remove_download($id)
    public static function remove_download($id) {
        global $prefix, $pdo;
        $t = $prefix."_downloads";
        $stmt = $pdo->prepare("DELETE FROM ".$t." WHERE id = ?");
        $stmt->execute(array($id));
    }

    public static function get_id($project_id, $version_id) {
        global $prefix;
        $t = $prefix."_downloads";
        $id = value($t, "id", "WHERE project_id = ? AND version_id = ?", array($project_id, $version_id));
        return $id;
    }

    #download($id)
    public static function download($id) {
        global $prefix, $configuration_values;
        $t = $prefix."_downloads";
        $file = value($t, "file_name", "WHERE id = ?", array($id));
        $downloads = value($t, "file_downloads", "WHERE id = ?", array($id));
        $location = base_directory.$configuration_values['file']['upload_directory'].$file;
        $type = new finfo(FILEINFO_MIME, $location);
        set_value($t, "file_downloads", $downloads + 1, "WHERE id = ?", array($id));
        header('Content-Description: File Transfer');
        header('Content-Type: '.$type);
        header('Content-Disposition: attachment; filename='.$location);
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: '.filesize($location));
    }
}