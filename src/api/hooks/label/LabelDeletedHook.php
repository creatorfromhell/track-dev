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
 * Class LabelDeletedHook
 */
class LabelDeletedHook extends Hook {

    public function __construct($project = 'not initialized', $list = 'not initialized', $id = 'not initialized') {
        parent::__construct("label_deleted_hook");
        $this->arguments = array(
            'project' => $project,
            'list' => $list,
            'id' => $id
        );
    }
}