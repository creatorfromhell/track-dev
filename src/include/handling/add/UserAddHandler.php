<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 1:20 AM
 * Version: Beta 2
 */

/**
 * Class UserAddHandler
 */
class UserAddHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('username', 'email', 'password', 'c_password', 'group');
    }

    public function handle() {
        parent::basic_handle();

        if(User::exists($this->post_vars['username'], false) || User::exists($this->post_vars['email'], true)) {
            throw new Exception("site->forms->exists->username");
        }

        if($this->post_vars['password'] != $this->post_vars['c_password']) {
            throw new Exception("site->forms->invalid->passwords");
        }
    }
}