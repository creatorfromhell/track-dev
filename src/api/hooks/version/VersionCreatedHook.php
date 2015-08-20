<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:11 PM
 * Version: Beta 2
 */

/**
 * Class VersionCreatedHook
 */
class VersionCreatedHook extends Hook {

    public function __construct($project = 'not initialized', $name = 'not initialized', $status = 'not initialized', $type = 'not initialized') {
        parent::__construct("version_created_hook");
        $this->arguments = array(
            'project' => $project,
            'name' => $name,
            'status' => $status,
            'type' => $type
        );
    }
}