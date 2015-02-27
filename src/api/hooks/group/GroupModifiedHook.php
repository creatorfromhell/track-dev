<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 11:55 AM
 * Version: Beta 2
 */

/**
 * Class GroupModifiedHook
 */
class GroupModifiedHook extends GroupHook {

    public function __construct($id = 'not initialized', $old_name = 'not initialized', $name = 'not initialized', $old_admin = 'not initialized', $admin = 'not initialized', $old_preset = 'not initialized', $preset = 'not initialized', $old_permissions = 'not initialized', $permissions = 'not initialized') {
        parent::__construct("group_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_name' => $old_name,
            'old_admin' => $old_admin,
            'old_preset' => $old_preset,
            'old_permissions' => $old_permissions,
            'name' => $name,
            'admin' => $admin,
            'preset' => $preset,
            'permissions' => $permissions
        );
    }
}