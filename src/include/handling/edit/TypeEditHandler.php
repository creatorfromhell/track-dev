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
        $this->required_variables = array('id', 'type-name', 'type-description', 'type-stable');
    }

    public function handle() {
        parent::basic_handle();

        $details = VersionFunc::type_details($this->post_vars['id']);
        if($details['name'] != $this->post_vars['type-name'] && has_values("version_types", " WHERE version_type = ?", array($this->post_vars['type-name']))) {
            throw new Exception("site->forms->exists->type");
        }
    }
}