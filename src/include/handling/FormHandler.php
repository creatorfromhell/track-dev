<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/3/2015
 * Time: 7:56 PM
 * Version: Beta 2
 */

/**
 * Class FormHandler
 */
abstract class FormHandler {

    public $post_vars = array();
    protected $required_variables = array();

    public function __construct($vars) {
        if(!empty($vars) && is_array($vars)) {
            foreach($vars as $key => $value) {
                $this->post_vars[$key] = StringFormatter::clean_input($value);
            }
        }
    }
    public abstract function handle();

    public function basic_handle() {
        $this->check_fields();
    }

    public function check_fields() {
        foreach($this->required_variables as &$field) {
            if(!isset($this->post_vars[$field]) && $this->post_vars[$field] != "0") {
                throw new Exception("site->forms->missing->".$field);
            }
        }
    }
}