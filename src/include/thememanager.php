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

    private $plugin_instance;

    /**
     * @var array
     */
    public $themes = array();
    /**
     * @var array
     */
    public static $shortcuts = array("%name", "%author", "%version", "%date", "%year", "%month", "%day");

    /**
     *
     */
    public function __construct($plugin_manager) {
        if($plugin_manager instanceof PluginManager) {
            $this->plugin_instance = $plugin_manager;
        }
        //load all themes
        $this->load_all();
    }

    /**
     *
     */
    public function load_all() {
        foreach(glob("resources/themes/*.xml") as $theme) {
            $path_info = pathinfo($theme);
            $this->load($path_info['filename']);
        }
    }

    /**
     * @param $name
     */
    public function load($name) {
        $file = @simplexml_load_file("resources/themes/".$name.".xml", null, true);
        $this->themes[$name] = $file;

        $theme_load_hook = new ThemeLoadedHook($name, (string)$file->version);
        $this->plugin_instance->trigger($theme_load_hook);
    }

    /**
     * @param $name
     */
    public function save($name) {
        $this->themes[$name]->asXML("resources/themes/".$name.".xml");
    }

    /**
     * @param $name
     */
    public function reload($name) {
        $this->save($name);
        $this->load($name);
    }

    public function get_template($theme, $template) {
        $theme_directory = (string)$this->themes[$theme]->directory;
        $directory = "resources/themes/".$theme_directory."/templates/";
        $template_location = $directory.$template;
        if(file_exists($template_location)) {
            return $template_location;
        }
        if(isset($this->themes["Default"])) {
            $theme_directory = (string)$this->themes[$theme]->directory;
            return "resources/themes/".$theme_directory."/templates/".$template;
        }
        return $template;
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function replace_shortcuts($name, $value) {
        $theme = $this->themes[$name];
        $replacements = array((string)$theme->name, (string)$theme->author, (string)$theme->version, date("Y-m-d"), date('Y'), date('F'), date('l'));

        return str_replace(self::$shortcuts, $replacements, $value);
    }

    /**
     * @param $name
     * @return array
     */
    public function get_includes($name) {
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
