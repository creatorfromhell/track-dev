<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 1:21 AM
 * Version: Beta 2
 */

/**
 * Class UserEditHandler
 */
class UserEditHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('id', 'username', 'email', 'password', 'c_password', 'group');
    }

    public function handle() {
        parent::basic_handle();

        $user = User::load($this->post_vars['id'], false, true);

        if($user->name != $this->post_vars['username'] && User::exists($this->post_vars['username'], false) || $user->email != $this->post_vars['email'] && User::exists($this->post_vars['email'], true)) {
            throw new Exception("site->forms->exists->username");
        }

        if($this->post_vars['password'] != $this->post_vars['c_password']) {
            throw new Exception("site->forms->invalid->passwords");
        }
    }
}