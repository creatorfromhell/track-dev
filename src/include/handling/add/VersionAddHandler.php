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
        $this->required_variables = array('project', 'version-name', 'status', 'version-type');
    }

    public function handle() {
        parent::basic_handle();

        if(has_values("versions", " WHERE version_name = ?", array($this->post_vars['version-name']))) {
            throw new Exception("site->forms->exists->version");
        }

        if(isset($_POST['version_download'])) {
            upload_file($_FILES['version_download'], $this->post_vars['project']."-".$this->post_vars['version-name']);
        }
    }
}