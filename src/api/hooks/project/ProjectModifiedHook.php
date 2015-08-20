<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 11:35 AM
 * Version: Beta 2
 */

/**
 * Class ProjectModifiedHook
 */
class ProjectModifiedHook extends Hook {

    public function __construct($id = 'not initialized', $old_name = 'not initialized', $name = 'not initialized', $old_preset = 'not initialized', $preset = 'not initialized', $old_overseer = 'not initialized', $overseer = 'not initialized') {
        parent::__construct("project_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_name' => $old_name,
            'old_preset' => $old_preset,
            'old_overseer' => $old_overseer,
            'name' => $name,
            'preset' => $preset,
            'overseer' => $overseer
        );
    }
}