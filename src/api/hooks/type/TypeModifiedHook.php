<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:00 PM
 * Version: Beta 2
 */

/**
 * Class TypeModifiedHook
 */
class TypeModifiedHook extends TypeHook {

    public function __construct($id = 'not initialized', $old_name = 'not initialized', $name = 'not initialized', $old_stability = 'not initialized', $stability = 'not initialized', $old_description = 'not initialized', $description = 'not initialized') {
        parent::__construct("type_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_name' => $old_name,
            'old_stability' => $old_stability,
            'old_description' => $old_description,
            'name' => $name,
            'stability' => $stability,
            'description' => $description
        );
    }
}