<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:47 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:47 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class ThemeLoadedHook
 */
class ThemeLoadedHook extends Hook {

    public function __construct($theme = 'not initialized', $version = 'not initialized') {
        parent::__construct("theme_loaded_hook", array(
            'name' => $theme,
            'version' => $version
        ));
    }
}