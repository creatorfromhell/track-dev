<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/15/2015
 * Time: 9:21 PM
 * Version: Beta 2
 * Last Modified: 2/15/2015 at 9:21 PM
 * Last Modified by Daniel Vidmar.
 */

class UserRegistrationHook extends Hook {

    public function __construct($username = 'not initialized', $date = 'not initialized', $ip = 'not initialized') {
        parent::__construct("user_registration_hook");
        $this->arguments['username'] = $username;
        $this->arguments['date_time'] = $date;
        $this->arguments['ip'] = $ip;
    }
}