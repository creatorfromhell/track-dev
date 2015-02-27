<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:12 PM
 * Version: Beta 2
 */

/**
 * Class VersionReleasedHook
 */
class VersionReleasedHook extends VersionHook {

    public function __construct($id = 'not initialized') {
        parent::__construct("version_released_hook");
        $this->arguments = array(
            'id' => $id
        );
    }
}