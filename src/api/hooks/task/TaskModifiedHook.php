<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:18 PM
 * Version: Beta 2
 */

/**
 * Class TaskModifiedHook
 */
class TaskModifiedHook extends Hook {

    public function __construct($id = 'not initialized', $project = 'not initialized', $list = 'not initialized', $old_title = 'not initialized', $title = 'not initialized', $old_description = 'not initialized', $description = 'not initialized', $old_assignee = 'not initialized', $assignee = 'not initialized', $old_version = 'not initialized', $version = 'not initialized', $old_labels = 'not initialized', $labels = 'not initialized', $old_status = 'not initialized', $status = 'not initialized', $old_progress = 'not initialized', $progress = 'not initialized') {
        parent::__construct("task_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_title' => $old_title,
            'old_description' => $old_description,
            'old_assignee' => $old_assignee,
            'old_version' => $old_version,
            'old_labels' => $old_labels,
            'old_status' => $old_status,
            'old_progress' => $old_progress,
            'project' => $project,
            'list' => $list,
            'title' => $title,
            'description' => $description,
            'assignee' => $assignee,
            'version' => $version,
            'labels' => $labels,
            'status' => $status,
            'progress' => $progress
        );
    }
}