<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 11:27 AM
 * Version: Beta 2
 */

/**
 * Class AdminPanelLeaveHook
 */
class AdminLeaveHook extends Hook {

    public function __construct($user = 'not initialized', $page = 'not initialized') {
        parent::__construct("admin_leave_hook");
        $this->arguments = array(
            'user' => $user,
            'page' => $page,
        );
    }
}