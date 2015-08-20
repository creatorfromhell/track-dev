<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:56 AM
 * Version: Beta 2
 */

/**
 * Class ListEditHandler
 */
class ListEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'name', 'project', 'public', 'minimal', 'main', 'overseer', 'guest-view', 'guest-edit', 'view-permission', 'edit-permission');
    }

    public function handle() {
        parent::basic_handle();

        $id = $this->post_vars['id'];
        $details = ListFunc::list_details($id);

        if(!has_values("projects", " WHERE project = ?", array($this->post_vars['project']))) {
            throw new Exception("site->forms->invalid->project");
        }

        if($this->post_vars['name'] != $details['name'] && has_values("lists", " WHERE project = ? AND list = ?", array($this->post_vars['project'], $this->post_vars['name']))) {
            throw new Exception("site->forms->exists->list");
        }

        if($this->post_vars['project'] != $details['project']) {
            ListFunc::change_project($id, $this->post_vars['project']);
        }

        if($this->post_vars['name'] != $details['name']) {
            ListFunc::rename_list($id, $this->post_vars['name']);
        }

        if(ProjectFunc::get_main(ProjectFunc::get_id($details['project'])) != $id && $this->post_vars['main'] == 1) {
            ProjectFunc::change_main(ProjectFunc::get_id($this->post_vars['project']), ListFunc::get_id($this->post_vars['project'], $this->post_vars['name']));
        }
    }
}