<?php
/**
 * User: Daniel
 * Date: 4/25/2015
 * Time: 1:16 AM
 */

abstract class FileHook extends Hook {

    public function __construct($name = 'not initialized') {
        parent::__construct($name, array('file' => null));
        $this->web = true;
    }
}