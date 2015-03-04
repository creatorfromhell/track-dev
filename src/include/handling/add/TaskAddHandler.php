<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 1:36 AM
 * Version: Beta 2
 */

/**
 * Class TaskAddHandler
 */
class TaskAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('title', 'description', 'author', 'editable', 'status');
    }

    public function handle() {
        parent::basic_handle();

        if(!has_values("projects", " WHERE project = ?", array($this->post_vars['project']))) {
            throw new Exception("site->forms->invalid->project");
        }

        if(!has_values("lists", " WHERE project = ? AND list = ?", array($this->post_vars['project'], $this->post_vars['list']))) {
            throw new Exception("site->forms->invalid->list");
        }
    }
}