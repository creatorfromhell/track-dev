<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 5:16 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 5:16 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class TaskHook
 */
abstract class TaskHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array(
            'project' => null,
            'list' => null,
            'task' => null
        ));
        $this->web = true;
    }
}