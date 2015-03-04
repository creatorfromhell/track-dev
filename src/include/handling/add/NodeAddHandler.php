<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/3/2015
 * Time: 9:44 PM
 * Version: Beta 2
 */

/**
 * Class NodeAddHandler
 */
class NodeAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('node', 'description');
    }

    public function handle() {
        parent::basic_handle();
    }
}