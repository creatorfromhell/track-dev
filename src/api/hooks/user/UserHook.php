<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:31 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:31 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class UserHook
 */
abstract class UserHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array('username' => null));
        $this->web = true;
    }
}