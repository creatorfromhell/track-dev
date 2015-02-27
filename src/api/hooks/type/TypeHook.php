<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 5:58 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 5:58 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class VersionTypeHook
 */
abstract class TypeHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array('name' => null));
        $this->web = true;
    }
}