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

    private $plugin_instance;
    /**
     * @var array
     */
    public $languages = array();

    /**
     *
     */
    public function __construct($plugin_manager) {
        if($plugin_manager instanceof PluginManager) {
            $this->plugin_instance = $plugin_manager;
        }
        //load all languages
        $this->loadAll();
    }

    /**
     *
     */
    public function loadAll() {
        foreach(glob("resources/languages/*.xml") as $theme) {
            $path_info = pathinfo($theme);
            $this->load($path_info['filename']);
        }
    }

    /**
     * @param $name
     */
    public function load($name) {
        $file = @simplexml_load_file("resources/languages/".$name.".xml", null, true);
        $this->languages[((string)$file->short)] = $file;

        $language_load_hook = new LanguageLoadedHook($name, (string)$file->version);
        $this->plugin_instance->trigger($language_load_hook);
    }

    /**
     * @param $name
     */
    public function save($name) {
        $this->languages[$name]->asXML("resources/languages/".$name.".xml");
    }

    /**
     * @param $name
     */
    public function reload($name) {
        $this->save($name);
        $this->load($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function exists($name) {
        if($this->languages[$name] != null) {
            return true;
        }
        return false;
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    public function getValue($name, $path) {
        return (string)$this->languages[$name]->xpath(str_ireplace("->", "/", $path))[0];
    }
}
?>