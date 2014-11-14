<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/6/14
 * Time: 4:51 PM
 * Version: Beta 1
 * Last Modified: 3/6/14 at 4:51 PM
 * Last Modified by Daniel Vidmar.
 */

class LanguageManager {

    public $languages = array();

    public function __construct() {
        //load all languages
        $this->loadAll();
    }

    public function loadAll() {
        foreach(glob("resources/languages/*.xml") as $theme) {
            $name = explode(".", trim($theme, "resources/languages/"))[0];
            $this->load($name);
        }
    }

    public function load($name) {
        $file = @simplexml_load_file("resources/languages/".$name.".xml", null, true);
        $this->languages[((string)$file->short)] = $file;
    }

    public function save($name) {
        $this->languages[$name]->asXML("resources/languages/".$name.".xml");
    }

    public function reload($name) {
        $this->save($name);
        $this->load($name);
    }

    public function exists($name) {
        if($this->languages[$name] != null) {
            return true;
        }
        return false;
    }

    public function getValue($name, $path) {
        return (string)$this->languages[$name]->xpath(str_ireplace("->", "/", $path))[0];
    }
}
?>