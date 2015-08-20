<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 10:56 AM
 * Version: Beta 2
 */

/**
 * Class UserModifiedHook
 */
class UserModifiedHook extends Hook {

    public function __construct($id = 'not initialized', $old_name = 'not initialized', $name = 'not initialized', $old_email = 'not initialized', $email = 'not initialized', $old_group = 'not initialized', $group = 'not initialized') {
        parent::__construct("user_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_name' => $old_name,
            'old_email' => $old_email,
            'old_group' => $old_group,
            'name' => $name,
            'email' => $email,
            'group' => $group,
        );
    }
}