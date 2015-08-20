<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 10:57 AM
 * Version: Beta 2
 * Last Modified: 2/26/2015 at 10:57 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class ListModifiedHook
 */
class ListModifiedHook extends Hook {

    public function __construct($id = 'not initialized', $old_project = 'not initialized', $project = 'not initialized', $old_name = 'not initialized', $name = 'not initialized', $old_overseer = 'not initialized', $overseer = 'not initialized') {
        parent::__construct("list_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_project' => $old_project,
            'old_name' => $old_name,
            'old_overseer' => $old_overseer,
            'project' => $project,
            'name' => $name,
            'overseer' => $overseer
        );
    }
}