<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:53 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:53 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class NavigationHook
 */
abstract class NavigationHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array('tabs' => null));
    }
}