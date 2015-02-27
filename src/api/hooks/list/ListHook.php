<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:58 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:58 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class ListHook
 */
abstract class ListHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array(
            'project' => null,
            'list' => null
        ));
        $this->web = true;
    }
}