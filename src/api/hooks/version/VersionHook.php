<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 5:00 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 5:00 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class VersionHook
 */
abstract class VersionHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array(
            'project_name' => null,
            'version_name' => null
        ));
    }
}