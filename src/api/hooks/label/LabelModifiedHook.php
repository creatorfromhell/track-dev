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
 * Class LabelModifiedHook
 */
class LabelModifiedHook extends Hook {

    public function __construct($id = 'not initialized', $old_project = 'not initialized', $project = 'not initialized', $old_list = 'not initialized', $list = 'not initialized', $old_label = 'not initialized', $label = 'not initialized', $old_color = 'not initialized', $color = 'not initialized', $old_background = 'not initialized', $background = 'not initialized') {
        parent::__construct("label_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_project' => $old_project,
            'old_list' => $old_list,
            'old_label' => $old_label,
            'old_color' => $old_color,
            'old_background' => $background,
            'project' => $project,
            'list' => $list,
            'label' => $label,
            'color' => $color,
            'background' => $background
        );
    }
}