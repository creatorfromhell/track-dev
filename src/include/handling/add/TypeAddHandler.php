<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:32 AM
 * Version: Beta 2
 */

/**
 * Class TypeAddHandler
 */
class TypeAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('name', 'description', 'stable');
    }

    public function handle() {
        parent::basic_handle();

        if(has_values("version_types", " WHERE version_type = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->type");
        }
    }
}