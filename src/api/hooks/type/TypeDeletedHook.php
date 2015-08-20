<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:00 PM
 * Version: Beta 2
 */

/**
 * Class TypeDeletedHook
 */
class TypeDeletedHook extends Hook {

    public function __construct($id = 'not initialized') {
        parent::__construct("type_deleted_hook");
        $this->arguments = array(
            'id' => $id,
        );
    }
}