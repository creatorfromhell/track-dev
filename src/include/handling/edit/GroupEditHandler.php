<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/3/2015
 * Time: 11:34 PM
 * Version: Beta 2
 */

/**
 * Class GroupEditHandler
 */
class GroupEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'name', 'admin', 'preset');
    }

    public function handle() {
        parent::basic_handle();

        if(!has_values("groups", " WHERE id = ?", array($this->post_vars['id']))) {
            throw new Exception("site->forms->invalid->id");
        }

        $group = Group::load($this->post_vars['id']);
        if($this->post_vars['name'] != $group->name && has_values("groups", " WHERE group_name = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->group");
        }
    }
}