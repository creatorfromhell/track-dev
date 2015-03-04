<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:20 PM
 * Version: Beta 2
 */

/**
 * Class TaskDeletedHook
 */
class TaskDeletedHook extends Hook {

    public function __construct($project = 'not initialized', $list = 'not initialized', $id = 'not initialized') {
        parent::__construct("task_deleted_hook");
        $this->arguments = array(
            'project' => $project,
            'list' => $list,
            'id' => $id
        );
    }
}