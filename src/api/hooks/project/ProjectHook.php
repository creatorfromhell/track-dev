<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:44 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:44 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class ProjectHook
 */
abstract class ProjectHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array('project_name' => null));
    }
}