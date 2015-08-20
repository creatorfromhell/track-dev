<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:32 AM
 * Version: Beta 2
 */

/**
 * Class TypeEditHandler
 */
class TypeEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'name', 'description', 'stable');
    }

    public function handle() {
        parent::basic_handle();

        $details = VersionFunc::type_details($this->post_vars['id']);
        if($details['name'] != $this->post_vars['name'] && has_values("version_types", " WHERE version_type = ?", array($this->post_vars['name']))) {
            throw new Exception("site->forms->exists->type");
        }
    }
}