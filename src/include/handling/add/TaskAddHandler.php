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

        global $project, $list;
        if(!has_values("projects", " WHERE project = ?", array($project))) {
            throw new Exception("site->forms->invalid->project");
        }

        if(!has_values("lists", " WHERE project = ? AND list = ?", array($project, $list))) {
            throw new Exception("site->forms->invalid->list");
        }
    }
}