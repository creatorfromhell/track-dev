<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/3/2015
 * Time: 11:33 PM
 * Version: Beta 2
 */

/**
 * Class GroupAddHandler
 */
class GroupAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('name', 'admin', 'preset');
    }

    public function handle() {
        parent::basic_handle();

        if(has_values("groups", " WHERE group_name = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->group");
        }
    }
}