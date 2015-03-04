<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 10:55 AM
 * Version: Beta 2
 * Last Modified: 2/26/2015 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class LabelCreatedHook
 */
class LabelCreatedHook extends Hook {

    public function __construct($project = 'not initialized', $list = 'not initialized', $label = 'not initialized', $color = 'not initialized', $background = 'not initialized') {
        parent::__construct("label_created_hook");
        $this->arguments = array(
            'project' => $project,
            'list' => $list,
            'label' => $label,
            'color' => $color,
            'background' => $background
        );
    }
}