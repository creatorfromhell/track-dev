<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/18/2015
 * Time: 1:24 AM
 * Version: Beta 2
 * Last Modified: 2/18/2015 at 1:24 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class NavigationAdminHook
 */
class NavigationAdminHook extends Hook {

    public function __construct($tabs = 'not initialized') {
        parent::__construct("navigation_admin_hook");
        $this->arguments['tabs'] = $tabs;
    }
}