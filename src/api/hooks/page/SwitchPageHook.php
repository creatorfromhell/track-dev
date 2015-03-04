<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/4/2015
 * Time: 11:27 AM
 * Version: Beta 2
 */

/**
 * Class SwitchPage
 */
class SwitchPageHook extends Hook {

    public function __construct($previous = 'not initialized', $page = 'not initialized') {
        parent::__construct("page_switch_hook");
        $this->arguments = array(
            'previous' => $previous,
            'page' => $page,
        );
    }
}