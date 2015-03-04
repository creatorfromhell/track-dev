<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:11 AM
 * Version: Beta 2
 */

/**
 * Class LabelAddHandler
 */
class LabelAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('project', 'list', 'labelname', 'textcolor', 'backgroundcolor');
    }

    public function handle() {
        parent::basic_handle();
    }
}