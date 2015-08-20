<?php
/**
 * Created by Daniel Vidmar.
 * Date: 2/16/2015
 * Time: 4:49 PM
 * Version: Beta 2
 * Last Modified: 2/16/2015 at 4:49 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class LanguageLoadedHook
 */
class LanguageLoadedHook extends Hook {

    public function __construct($language = 'not initialized', $version = 'not initialized') {
        parent::__construct("language_loaded_hook", array(
            'name' => $language,
            'version' => $version
        ));
    }
}