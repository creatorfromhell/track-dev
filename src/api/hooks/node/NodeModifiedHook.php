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
 * Class NodeModifiedHook
 */
class NodeModifiedHook extends NodeHook {

    public function __construct($id = 'not initialized', $old_node = 'not initialized', $node = 'not initialized', $old_description = 'not initialized', $description = 'not initialized') {
        parent::__construct("node_modified_hook");
        $this->arguments = array(
            'id' => $id,
            'old_node' => $old_node,
            'node' => $node,
            'old_description' => $old_description,
            'description' => $description
        );
    }
}