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
        $this->required_variables = array('id', 'project', 'version-name', 'status', 'version-type');
    }

    public function handle() {
        parent::basic_handle();

        $id = $this->post_vars['id'];
        $details = VersionFunc::version_details($id);

        if($details['name'] != $this->post_vars['version-name'] && has_values("versions", " WHERE version_name = ?", array($this->post_vars['version-name']))) {
            throw new Exception("site->forms->exists->version");
        }

        if(isset($_POST['version_download'])) {
            upload_file($_FILES['version_download'], $this->post_vars['project']."-".$this->post_vars['version-name']);
        }
    }
}