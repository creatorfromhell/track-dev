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
        $this->themesDirectory = rtrim($this->configuration->config["urls"]["base_url"], "/")."/".rtrim($this->configuration->config["urls"]["installation_path"], "/")."/resources/themes";

        //load all themes
        foreach(glob($this->themesDirectory."/*.xml") as $theme) {
            $name = explode(".", $theme);
            $this->load($name);
        }
    }

    public function load($name) {
        $file = new SimpleXMLElement($this->themesDirectory."/".$name.".xml", null, true);
        array_push($this->themes, $file->name);
        $this->themes[$file->name] = $file;
    }

    public function save($name) {
        $this->themes[$name]->asXML($this->themesDirectory."/".$name.".xml");
    }

    public function reload($name) {
        $this->save($name);
        $this->load($name);
    }
}