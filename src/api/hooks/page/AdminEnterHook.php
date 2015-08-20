<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 11:27 AM
 * Version: Beta 2
 */

/**
 * Class AdminPanelEnterHook
 */
class AdminEnterHook extends Hook {

    public function __construct($user = 'not initialized', $previous = 'not initialized') {
        parent::__construct("admin_enter_hook");
        $this->arguments = array(
            'user' => $user,
            'previous' => $previous,
        );
    }
}