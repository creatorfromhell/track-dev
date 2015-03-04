<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 10:56 AM
 * Version: Beta 2
 * Last Modified: 2/26/2015 at 10:56 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class ListCreatedHook
 */
class ListCreatedHook extends Hook {

    public function __construct($project = 'not initialized', $name = 'not initialized', $creator = 'not initialized', $overseer = 'not initialized') {
        parent::__construct("list_created_hook");
        $this->arguments = array(
            'project' => $project,
            'name' => $name,
            'creator' => $creator,
            'overseer' => $overseer
        );
    }
}