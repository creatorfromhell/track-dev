<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 10:59 AM
 * Version: Beta 2
 * Last Modified: 2/26/2015 at 10:59 AM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class NodeCreatedHook
 */
class NodeCreatedHook extends NodeHook {

    public function __construct($node = 'not initialized', $description = 'not initialized') {
        parent::__construct("node_created_hook");
        $this->arguments = array(
            'node' => $node,
            'description' => $description
        );
    }
}