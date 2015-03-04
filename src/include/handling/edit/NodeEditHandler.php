<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/3/2015
 * Time: 10:23 PM
 * Version: Beta 2
 */

/**
 * Class NodeEditHandler
 */
class NodeEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'node', 'description');
    }

    public function handle() {
        parent::basic_handle();
    }
}