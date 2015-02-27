<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 11:59 AM
 * Version: Beta 2
 */

/**
 * Class TypeCreatedHook
 */
class TypeCreatedHook extends TypeHook {

    public function __construct($name = 'not initialized', $stability = 'not initialized', $description = 'not initialized') {
        parent::__construct("type_created_hook");
        $this->arguments = array(
            'name' => $name,
            'stability' => $stability,
            'description' => $description
        );
    }
}