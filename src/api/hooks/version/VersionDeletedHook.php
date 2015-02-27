<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:12 PM
 * Version: Beta 2
 */

/**
 * Class VersionDeletedHook
 */
class VersionDeletedHook extends VersionHook {

    public function __construct($project = 'not initialized', $id = 'not initialized') {
        parent::__construct("version_deleted_hook");
        $this->arguments = array(
            'project' => $project,
            'id' => $id
        );
    }
}