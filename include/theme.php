<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Alpha 1
 * Last Modified: 12/13/13 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

class Theme {

	//The SimpleXML Element of this theme.
	public $xml;
    //The name of this theme
    public $name;
    //The author of this theme
    public $author;
    //The version of this theme
    public $version;
    //The copyright notice to be displayed in the footer for this theme
    public $notice;
    //The CSS Files required by this theme in string form
    public $css;
    //The CSS Files required by this theme in array form
    public $cssArray;
    //The JS Files required by this theme in string form
    public $js;
    //The JS Files required by this theme in array form
    public $jsArray;


    public function __construct($name) {
        $this->name = $name;
    }

    public function load() {
		$this->xml = new SimpleXMLElement('#', null, true);
    }

    public function reload() {
        $this->save();
        $this->load();
    }

    public function save() {
		
    }
}