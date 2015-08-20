<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 10:56 AM
 * Version: Beta 2
 */

/**
 * Class UserDeletedHook
 */
class UserDeletedHook extends Hook {

    public function __construct($id = 'not initialized') {
        parent::__construct("user_deleted_hook");
        $this->arguments = array(
            'id' => $id,
        );
    }
}