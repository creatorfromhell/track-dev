<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:51 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:51 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class UserLogoutHook
 */
class UserLogoutHook extends Hook {

    public function __construct($username = 'not initialized', $date = 'not initialized', $ip = 'not initialized') {
        parent::__construct("user_logout_hook");
        $this->arguments['username'] = $username;
        $this->arguments['date_time'] = $date;
        $this->arguments['ip'] = $ip;
    }
} 