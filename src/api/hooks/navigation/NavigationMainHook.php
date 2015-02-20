<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/18/2015
 * Time: 1:20 AM
 * Version: Beta 2
 * Last Modified: 2/18/2015 at 1:20 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class NavigationMainHook
 */
class NavigationMainHook extends NavigationHook {

    public function __construct(&$tabs = 'not initialized') {
        parent::__construct("navigation_main_hook");
        $this->arguments['tabs'] = $tabs;
    }
} 