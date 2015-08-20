<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:46 AM
 * Version: Beta 2
 */

/**
 * Class ProjectAddHandler
 */
class ProjectAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('name', 'author', 'public', 'preset', 'overseer');
    }

    public function handle() {
        parent::basic_handle();

        if(has_values("projects", " WHERE project = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->project");
        }

        if($this->post_vars['preset'] == 1) {
            ProjectFunc::remove_preset();
        }
    }
}