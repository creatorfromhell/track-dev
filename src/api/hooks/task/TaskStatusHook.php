<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:19 PM
 * Version: Beta 2
 */

/**
 * Class TaskStatusHook
 */
class TaskStatusHook extends TaskHook {

    public function __construct($project = 'not initialized', $list = 'not initialized', $id = 'not initialized', $status = 'not initialized') {
        parent::__construct("task_status_hook");
        $this->arguments = array(
            'project' => $project,
            'list' => $list,
            'id' => $id,
            'status' => $status
        );
    }
}