<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/3/2015
 * Time: 6:05 PM
 * Version: Beta 2
 */

/**
 * Class InvalidParameterTypeException
 */
class InvalidParameterTypeException extends Exception {

    public function __construct($class, $parameter, $type, $code = 0) {
        if(is_object($class)) {
            $class = get_class($class);
        }
        $message = "Class \"".$class."\" expected parameter \"$".$parameter."\" to be of type \"".$type."\".";
        parent::__construct($message, $code);
    }
}