<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 10:59 AM
 * Version: Beta 2
 * Last Modified: 2/26/2015 at 10:59 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class NodeDeletedHook
 */
class NodeDeletedHook extends Hook {

    public function __construct($id = 'not initialized') {
        parent::__construct("node_deleted_hook");
        $this->arguments = array(
            'id' => $id
        );
    }
}