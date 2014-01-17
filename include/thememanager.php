<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/15/14
 * Time: 5:06 PM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 5:06 PM
 * Last Modified by Daniel Vidmar.
 */
class ThemeManager {

    public $themes = array();

    public function __construct() {
        //load all themes
        $this->loadAll();
    }

    public function loadAll() {
        foreach(glob("resources/themes/*.xml") as $theme) {
            $name = explode(".", trim($theme, "resources/themes/"))[0];
            $this->load($name);
        }
    }

    public function load($name) {
        $file = @simplexml_load_file("resources/themes/".$name.".xml", null, true);
        $this->themes[$name] = $file;
    }

    public function save($name) {
        $this->themes[$name]->asXML("resources/themes/".$name.".xml");
    }

    public function reload($name) {
        $this->save($name);
        $this->load($name);
    }
}