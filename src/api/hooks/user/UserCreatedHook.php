<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 10:56 AM
 * Version: Beta 2
 */

/**
 * Class UserCreatedHook
 */
class UserCreatedHook extends Hook {

    public function __construct($name = 'not initialized', $email = 'not initialized', $group = 'not initialized') {
        parent::__construct("user_created_hook");
        $this->arguments = array(
            'name' => $name,
            'email' => $email,
            'group' => $group,
        );
    }
}