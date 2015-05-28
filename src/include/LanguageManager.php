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

    private $string_formatter;
    /**
     * @var array
     */
    public $languages = array();

    /**
     *
     */
    public function __construct($plugin_manager, $string_formatter) {
        if(!($plugin_manager instanceof PluginManager)) {
            throw new InvalidParameterTypeException($this, "plugin_manager", "PluginManager");
        }
        if(!($string_formatter instanceof StringFormatter)) {
            throw new InvalidParameterTypeException($this, "string_formatter", "StringFormatter");
        }
        $this->plugin_instance = $plugin_manager;
        $this->string_formatter = $string_formatter;
        //load all languages
        $this->load_all();
    }

    /**
     *
     */
    public function load_all() {
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
        $this->languages[(string)$file->xpath("short")[0]] = $file;

        $language_load_hook = new LanguageLoadedHook($name, (string)$file->xpath("version")[0]);
        $this->plugin_instance->trigger($language_load_hook);
    }

    /**
     * @param $name
     */
    public function save($name) {
        $language = $this->languages[$name];
        if($language instanceof SimpleXMLElement) {
            $language->asXML("resources/languages/" . $name . ".xml");
        }
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
     * @param $replace_shortcuts
     * @return string
     */
    public function get_value($name, $path, $replace_shortcuts = true) {
        $language = $this->languages[$name];
        if($language instanceof SimpleXMLElement) {
            $value = (string)$language->xpath(str_ireplace("->", "/", $path))[0];
            if(!$replace_shortcuts) {
                return $value;
            }
            return $this->string_formatter->replace_shortcuts($value);
        }
        return $path;
    }
}