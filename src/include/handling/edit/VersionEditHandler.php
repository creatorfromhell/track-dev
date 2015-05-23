<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 1:12 AM
 * Version: Beta 2
 */

/**
 * Class VersionEditHandler
 */
class VersionEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'project', 'name', 'status', 'type');
    }

    public function handle() {
        parent::basic_handle();

        $id = $this->post_vars['id'];
        $details = VersionFunc::version_details($id);

        $file = $_FILES['download'];
        $download = "";
        if($file["error"] != 0) {
            $type = pathinfo(basename($file['name']), PATHINFO_EXTENSION);
            $new_name = $this->post_vars['project']."-".$this->post_vars['name'];
            upload_file($file, $new_name);
            $download = $new_name.".".$type;
        }

        if($details['name'] != $this->post_vars['name'] && has_values("versions", " WHERE version_name = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->version");
        }

        if(!empty($download)) {
            $this->post_vars['version_download'] = $download;
        }
    }
}