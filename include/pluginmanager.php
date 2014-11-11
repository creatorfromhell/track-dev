<?php
class PluginManager {
	public $plugins = array();
	public $hooks = array();
	
	public function bind($hook, $callback, $priority = 10) {
		if($priority > 10 || $priority < 1) { $priorty = 10; }
		$this->hooks[$hook][$priority][] = $callback;
	}
	
	public function trigger($hook) {
		if(!$hook instanceof Hook) {
			return;
		}
		
		$arguments = null;
		
		if(isset($this->hooks[$hook->friendlyName])) {
			for($i = 1; $i <= 10; $i++) {
				foreach($this->hooks[$hook->friendlyName][$i] as $callback) {
					$returnArguments = call_user_func($callback, $hook->arguments);
					if(is_array($returnArguments)) {
						$arguments = $returnArguments;
					}
				}
			}
		}
		if(empty($arguments)) {
			$arguments = $hook->arguments;
		}
	}
	
	public function loadAll() {
	
	}
	
	public function
}
?>