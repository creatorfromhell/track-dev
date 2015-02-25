<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:59 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:59 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class LabelHook
 */
abstract class LabelHook extends Hook {

    public function __construct($name) {
        parent::__construct($name, array(
            'project_name' => null,
            'list_name' => null,
            'label_name' => null
        ));
        $this->web = true;
    }
}