<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:12 AM
 * Version: Beta 2
 */

/**
 * Class LabelEditHandler
 */
class LabelEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'project', 'list', 'name', 'color', 'background');
    }

    public function handle() {
        parent::basic_handle();
    }
}