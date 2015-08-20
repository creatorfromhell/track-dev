<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:12 PM
 * Version: Beta 2
 */

/**
 * Class VersionModifiedHook
 */
class VersionModifiedHook extends Hook {

    public function __construct($id = 'not initialized', $old_project = 'not initialized', $project = 'not initialized', $old_name = 'not initialized', $name = 'not initialized', $old_status = 'not initialized', $status = 'not initialized', $old_type = 'not initialized', $type = 'not initialized') {
        parent::__construct("version_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_project' => $old_project,
            'old_name' => $old_name,
            'old_status' => $old_status,
            'old_type' => $old_type,
            'project' => $project,
            'name' => $name,
            'status' => $status,
            'type' => $type
        );
    }
}