<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 11:55 AM
 * Version: Beta 2
 */

/**
 * Class GroupCreatedHook
 */
class GroupCreatedHook extends Hook {

    public function __construct($name = 'not initialized', $admin = 'not initialized', $preset = 'not initialized', $permissions = 'not initialized') {
        parent::__construct("group_created_hook");
        $this->arguments = array(
            'name' => $name,
            'admin' => $admin,
            'preset' => $preset,
            'permissions' => $permissions
        );
    }
}