<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 10:58 AM
 * Version: Beta 2
 * Last Modified: 2/26/2015 at 10:58 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class LabelDeletedHook
 */
class ListDeletedHook extends Hook {

    public function __construct($project = 'not initialized', $id = 'not initialized') {
        parent::__construct("list_deleted_hook");
        $this->arguments = array(
            'project' => $project,
            'id' => $id
        );
    }
}