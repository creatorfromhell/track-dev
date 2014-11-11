<?php
abstract class Plugin {
	protected $path = "resources/plugins/%name.php";
	protected $directory = "resources/plugins/%name/";

	public abstract function enable();
	public abstract function disable();
}
?>