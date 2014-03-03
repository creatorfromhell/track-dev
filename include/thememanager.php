<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/15/14
 * Time: 5:06 PM
 * Version: Beta 1
 * Last Modified: 1/24/14 at 1:55 PM
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

    public function replaceShortcuts($name, $value) {
        $theme = $this->themes[$name];

        $s = str_ireplace("%author", (string)$theme->author, $value);
        $s1 = str_ireplace("%date", Date('Y'), $s);
        $s2 = str_ireplace("%name", (string)$theme->name, $s1);
        $s3 = str_ireplace("%version", (string)$theme->version, $s2);

        return $s3;
    }

    //Get functions
    public function getIncludes($name) {
        $theme = $this->themes[$name];
        $includes = array();
        if($this->containsJS($name)) {
            $js = explode(",", ((string)$theme->js));

            foreach($js as $file) {
                $includes[] = "js/".rtrim($file, ".js").".js";
            }
        }

        if($this->containsCSS($name)) {
            $css = explode(",", ((string)$theme->css));

            foreach($css as $file) {
                $includes[] = "css/".rtrim($file, ".css").".css";
            }
        }
        return $includes;
    }

    public function containsJS($name) {
        $theme = $this->themes[$name];
        if(is_null($theme->js) || ((string)$theme->js) === "") {
            return false;
        }
        return true;
    }

    public function containsCSS($name) {
        $theme = $this->themes[$name];
        if(is_null($theme->css) || ((string)$theme->css) === "") {
            return false;
        }
        return true;
    }
}