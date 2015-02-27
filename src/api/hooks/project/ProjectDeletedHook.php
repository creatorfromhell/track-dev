<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/26/2015
 * Time: 11:35 AM
 * Version: Beta 2
 */

/**
 * Class ProjectDeletedHook
 */
class ProjectDeletedHook extends ProjectHook {

    public function __construct($id) {
        parent::__construct("project_deleted_hook");
        $this->arguments = array(
            'id' => $id
        );
    }
}