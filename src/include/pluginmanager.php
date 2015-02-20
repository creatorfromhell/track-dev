<?php
class PluginManager {

    private $PLUGIN_DIRECTORY = "/resources/plugins/";
    private $base_directory = "";

    /**
     * @var array
     */
    public $plugins = array();

    /**
     * @var array
     */
    private $hooks = array();

    public function __construct($directory) {
        $this->base_directory = $directory;
        $this->initialize_hooks();
        $this->load_all();
    }

    /**
     * Initializes all hooks.
     */
    private function initialize_hooks() {
        $hook_directory = $this->base_directory."/api/hooks/";
        $this->load_hooks($hook_directory);
        $this->load_hooks($hook_directory."*/");
    }

    /**
     * Loads all hook php files from the specified directory
     * @param $directory
     */
    private function load_hooks($directory) {
        foreach(glob($directory."*.php", GLOB_NOSORT) as $hook) {
            require_once($hook);
            $path_info = pathinfo($hook);
            $this->add_hook($path_info['filename']);
        }
    }

    /**
     * Adds the name of the specified hook to $hooks using reflection.
     * @param $class_name
     */
    private function add_hook($class_name) {
        $reflector = new ReflectionClass($class_name);
        if(!$reflector->isAbstract() && $reflector->isSubclassOf("Hook") && $reflector->hasProperty("friendly_name")) {
            $name = $reflector->getProperty("friendly_name")->getValue($reflector->newInstance());
            $this->hooks[$name] = "";
        }
    }

    /**
     * @param $hook
     * @return bool
     */
    private function hook_exists($hook) {
        return isset($this->hooks[$hook]);
    }

    /**
     * @param $hook
     * @param $callback
     * @param int $priority
     */
    private function bind($hook, $callback, $priority = 5) {
        /*
         * Valid Hook Priorities:
         * 1 = High
         * 2 = Medium High
         * 3 = Medium
         * 4 = Medium Low
         * 5 = Low
         * 6 = Observe
         */
		if($priority > 6 || $priority < 1) { $priority = 5; }
        if($this->hook_exists($hook)) {
            $this->hooks[$hook][$priority][] = $callback;
        }
	}

    /**
     * @param $hook
     * @return array|null
     */
    public function trigger($hook) {
		if(!$hook instanceof Hook) {
			return null;
		}
		if(isset($this->hooks[$hook->friendly_name]) && is_array($this->hooks[$hook->friendly_name])) {
            $hook_array = $this->hooks[$hook->friendly_name];
            uksort($hook_array, function($a, $b) {
                if ($a == $b) return 0;
                return ($a < $b) ? -1 : 1;
            });
            foreach($hook_array as $callbacks) {
                foreach($callbacks as $callback) {
                    call_user_func_array(array($callback['class'], $callback['method']), array(&$hook->arguments));
                }
            }
		}
	}

    /**
     *
     */
    public function load_all() {
        foreach(glob($this->base_directory.$this->PLUGIN_DIRECTORY."*.php", GLOB_NOSORT) as $plugin) {
            include_once($plugin);
            $path_info = pathinfo($plugin);
            $reflector = new ReflectionClass($path_info['filename']);
            if($reflector->isSubclassOf('Plugin')) {
                $instance = $reflector->newInstance();
                if($reflector->hasMethod('enable')) {
                    $reflector->getMethod('enable')->invoke($instance);
                }
                if(!$reflector->getDocComment()) {
                    throw new InvalidPluginInfoException($path_info['filename'].".php");
                }
                $plugin_info = $this->parse_properties($reflector->getDocComment(), array('name', 'version', 'author', 'license', 'link', 'copyright'));
                if(!isset($plugin_info['name'])) {
                    $plugin_info['name'] = $path_info['filename'];
                }
                $this->plugins[$plugin_info['name']] = array(
                    'file' => $plugin,
                    'info' => $plugin_info
                );
                $this->load_callbacks($reflector);
            }
        }
	}

    private function load_callbacks($reflector)
    {
        if ($reflector instanceof ReflectionClass) {
            $methods = $reflector->getMethods();
            foreach ($methods as &$method) {
                if (!$method->getDocComment()) {
                    continue;
                }
                $comment = $method->getDocComment();
                if (strpos($comment, '@hook-callback') === false || strpos($comment, '@hook') === false) {
                    continue;
                }
                $callback = $this->parse_properties($comment, array('hook', 'priority'));
                if(empty($callback['priority'])) {
                    $callback = array('priority' => 5);
                }
                $callback['callable'] = array(
                    'class' => $reflector->newInstance(),
                    'method' => $method->name,
                );
                $this->bind($callback['hook'], $callback['callable'], $callback['priority']);
            }
        }
    }

    private function parse_properties($properties_string, $valid_properties) {
        $return = array();
        $callback_properties = explode('@', str_ireplace('*', '', trim(substr($properties_string, 3, -2))));
        foreach($callback_properties as &$property) {
            $array = explode(' ', trim($property));
            if(in_array(trim($array[0]), $valid_properties)) {
                $return[trim($array[0])] = trim($array[1]);
            }
        }
        return $return;
    }
}
?>