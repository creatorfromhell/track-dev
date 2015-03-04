<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 12:14 AM
 * Version: Beta 2
 */

/**
 * Class LoginHandler
 */
class LoginHandler extends FormHandler {

    public function __construct($vars) {
        parent::__construct($vars);
        $this->required_variables = array('username', 'password');
    }

    public function handle() {
        parent::basic_handle();

        $name = $this->post_vars['username'];
        $email = (!valid_email($name)) ? false : true;

        if(!User::exists($name, $email) || !check_hash(User::get_hashed_password($name, $email), $this->post_vars['password'])) {
            throw new Exception("site->forms->invalid->login");
        }

        $user = User::load($name, $email);
        global $configuration_values;
        if($configuration_values["main"]["email_activation"] && $user->activated != 1) {
            throw new Exception("site->forms->missing->activation");
        }
    }
}