<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 1:11 AM
 * Version: Beta 2
 */

/**
 * Class VersionAddHandler
 */
class VersionAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('project', 'name', 'status', 'type');
    }

    public function handle() {
        parent::basic_handle();

        $file = $_FILES['download'];
        $download = "";
        if($file["error"] != 0) {
            $type = pathinfo(basename($file['name']), PATHINFO_EXTENSION);
            $new_name = $this->post_vars['project']."-".$this->post_vars['name'];
            upload_file($file, $new_name);
            $download = $new_name.".".$type;
        }

        if(has_values("versions", " WHERE version_name = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->version");
        }

        if(!empty($download)) {
            $this->post_vars['version_download'] = $download;
        }
    }
}