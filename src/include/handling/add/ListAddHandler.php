<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:56 AM
 * Version: Beta 2
 */

/**
 * Class ListAddHandler
 */
class ListAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('name', 'author', 'project', 'public', 'minimal', 'main', 'overseer', 'guest-view', 'guest-edit', 'view-permission', 'edit-permission');
    }

    public function handle() {
        parent::basic_handle();

        if(!has_values("projects", " WHERE project = ?", array($this->post_vars['project']))) {
            throw new Exception("site->forms->invalid->project");
        }

        if(has_values("lists", " WHERE project = ? AND list = ?", array($this->post_vars['project'], $this->post_vars['name']))) {
            throw new Exception("site->forms->exists->list");
        }

        if($this->post_vars['main'] == 1) {
            ProjectFunc::change_main(ProjectFunc::get_id($this->post_vars['project']), ListFunc::get_id($this->post_vars['project'], $this->post_vars['name']));
        }
    }
}