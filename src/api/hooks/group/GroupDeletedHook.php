<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 11:55 AM
 * Version: Beta 2
 */

/**
 * Class GroupDeletedHook
 */
class GroupDeletedHook extends Hook {

    public function __construct($id = 'not initialized') {
        parent::__construct("group_deleted_hook");
        $this->arguments = array(
            'id' => $id
        );
    }
}