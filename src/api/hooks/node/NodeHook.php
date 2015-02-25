<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 5:56 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 5:56 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class NodeHook
 */
abstract class NodeHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array('node' => null));
        $this->web = true;
    }
}