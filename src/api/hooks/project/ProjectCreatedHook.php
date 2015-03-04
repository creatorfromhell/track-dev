<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 11:24 AM
 * Version: Beta 2
 * Last Modified: 2/26/2015 at 11:24 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class ProjectCreatedHook
 */
class ProjectCreatedHook extends Hook {

    public function __construct($name = 'not initialized', $preset = 'not initialized', $creator = 'not initialized', $overseer = 'not initialized') {
        parent::__construct("project_created_hook");
        $this->arguments = array(
            'name' => $name,
            'preset' => $preset,
            'creator' => $creator,
            'overseer' => $overseer
        );
    }
}