<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:17 PM
 * Version: Beta 2
 */

/**
 * Class TaskCreatedHook
 */
class TaskCreatedHook extends TaskHook {

    public function __construct($project = 'not initialized', $list = 'not initialized', $title = 'not initialized', $description = 'not initialized', $author = 'not initialized', $assignee = 'not initialized', $version = 'not initialized', $labels = 'not initialized', $status = 'not initialized', $progress = 'not initialized') {
        parent::__construct("task_created_hook");
        $this->arguments = array(
            'project' => $project,
            'list' => $list,
            'title' => $title,
            'description' => $description,
            'author' => $author,
            'assignee' => $assignee,
            'version' => $version,
            'labels' => $labels,
            'status' => $status,
            'progress' => $progress
        );
    }
}