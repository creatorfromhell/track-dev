<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 5:17 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 5:17 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class GroupHook
 */
abstract class GroupHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array('group_name' => null));
        $this->web = true;
    }
}