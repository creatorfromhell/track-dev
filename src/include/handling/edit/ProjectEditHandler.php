<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:46 AM
 * Version: Beta 2
 */

/**
 * Class ProjectEditHandler
 */
class ProjectEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'name', 'author', 'public', 'preset', 'overseer');
    }

    public function handle() {
        parent::basic_handle();

        $id = $this->post_vars['id'];
        $details = ProjectFunc::project_details($id);
        if($details['name'] != $this->post_vars['name'] && has_values("projects", " WHERE project = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->project");
        }

        if($details['preset'] == 0 && $this->post_vars['preset'] == 1) {
            ProjectFunc::remove_preset();
        }

        if($details['name'] != $this->post_vars['name']) {
            ProjectFunc::rename_project($id, $details['name'], $this->post_vars['name']);
        }
    }
}