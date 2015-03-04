<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 12:12 PM
 * Version: Beta 2
 */

/**
 * Class VersionStatusHook
 */
class VersionStatusHook extends Hook {

    public function __construct($id = 'not initialized', $status = 'not initialized') {
        parent::__construct("version_status_hook");
        $this->arguments = array(
            'id' => $id,
            'status' => $status
        );
    }
}