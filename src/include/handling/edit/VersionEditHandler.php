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

        if($details['name'] != $this->post_vars['name'] && has_values("versions", " WHERE version_name = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->version");
        }

        if(isset($_POST['download'])) {
            upload_file($_FILES['download'], $this->post_vars['project']."-".$this->post_vars['name']);
        }
    }
}