<?php
/**
 * Created by Daniel Vidmar.
 * Date: 1/15/14
 * Time: 5:06 PM
 * Version: Beta 1
 * Last Modified: 1/15/14 at 5:06 PM
 * Last Modified by Daniel Vidmar.
 */

//Include the configuration class.
require_once("config.php");
class ThemeManager {

    public $themes = array();

    //Instance of the Configuration Class
    private $configuration;

    //path to the themes directory
    private $themesDirectory;

    public function __construct() {
        $this->configuration = new Configuration();
        $this->themesDirectory = rtrim($this->configuration->config["urls"]["base_url"], "/").rtrim($this->configuration->config["urls"]["installation_path"], "/")."/resources/themes/";

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
        $file = @simplexml_load_file($this->themesDirectory.$name.".xml", null, true);
        $this->themes[$name] = $file;
    }

    public function save($name) {
        $this->themes[$name]->asXML($this->themesDirectory.$name.".xml");
    }

    public function reload($name) {
        $this->save($name);
        $this->load($name);
    }
}