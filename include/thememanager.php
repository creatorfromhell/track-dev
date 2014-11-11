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
    public static $shortcuts = array("%name", "%author", "%version", "%date", "%year", "%month", "%day");

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
        $replacements = array((string)$theme->name, (string)$theme->author, (string)$theme->version, date("Y-m-d"), date('Y'), date('F'), date('l'));

        return str_replace(self::$shortcuts, $replacements, $value);
    }

    //Get functions
    public function getIncludes($name) {
        $theme = $this->themes[$name];
        $includes = array();

        foreach(glob("resources/themes/".(string)$theme->directory."/js/*.js") as $js) {
            $includes[] = '<script src="'.$js.'?'.time().'" type="text/javascript"></script>';
        }

        foreach(glob("resources/themes/".(string)$theme->directory."/css/*.css") as $css) {
            $includes[] = '<link href="'.$css.'?'.time().'" rel="stylesheet" type="text/css" />';
        }
        return $includes;
    }
}