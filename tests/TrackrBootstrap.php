<?php
/**
 * Created by Daniel Vidmar.
 * Date: 11/14/14
 * Time: 12:03 AM
 * Version: Beta 2
 * Last Modified: 11/14/14 at 12:03 AM
 * Last Modified by Daniel Vidmar.
 */
function api_loader($class) {
    load("/src/api/".$class.".php");
}

function include_loader($class) {
    load("/src/include/".$class.".php");
}

function class_loader($class) {
    load("/src/include/class/".$class.".php");
}

function function_loader($class) {
    load("/src/include/function/".$class.".php");
}

function load($file) {
    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('api_loader');
spl_autoload_register('include_loader');
spl_autoload_register('class_loader');
spl_autoload_register('function_loader');
?>