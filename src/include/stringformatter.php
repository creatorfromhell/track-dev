<?php
/**
 * Created by Daniel Vidmar.
 * Date: 3/11/14
 * Time: 3:20 PM
 * Version: Beta 1
 * Last Modified: 3/11/14 at 3:20 PM
 * Last Modified by Daniel Vidmar.
 */

class StringFormatter {

    public $languageinstance;

    private static $shortcuts = array("%user", "%project", "%list", "%theme", "%none");
    private $replacements;

    private $dateFormat;

    private $blacklist;
    private $blacklist_replacements;

    public function __construct($user, $project, $list, $config, $language) {
        $this->languageinstance = $language;
        $this->replacements = array($user, $project, $list, $config["main"]["theme"], ((string)$language->site->tables->none));
        $blacklist = $config["main"]["blacklist"];
        $this->dateFormat = $config["main"]["dateformat"];
        if($blacklist != null && trim($blacklist) != "") {
            $this->blacklist = explode(',', $blacklist);
        } else {
            $this->blacklist = array();
        }
        $this->blacklist_replacements = array();
        $this->generateReplacements();
    }

    public function replace($string) {
        return $this->removeBlacklistWords($this->replaceShortcuts($string));
    }

    public function replaceShortcuts($string) {
        return str_ireplace(self::$shortcuts, $this->replacements, $string);
    }

    public function removeBlacklistWords($string) {
        return str_ireplace($this->blacklist, $this->blacklist_replacements, $string);
    }

    public function formatDate($date) {
        $d = explode(" ", $date);
        $date_parts = explode("-", $d[0]);

        $replace = array("d", "m", "y");
        $replacements = array($date_parts[2], $date_parts[1], $date_parts[0]);
        return str_ireplace($replace, $replacements, $this->dateFormat);
    }

    public function generateReplacements() {
        if($this->blacklist != null && count($this->blacklist) > 0) {
            $count = count($this->blacklist);
            $i = 0;
            $replacements = "";
            foreach($this->blacklist as &$word) {
                $length = strlen($word);
                $value = substr($word, 0, 1).str_repeat('*', $length - 2).substr($word, $length - 1, 1);
                ($i < $count) ? $replacements .= $value."," : $replacements .= $value;
                $i++;
            }
            $this->blacklist_replacements = explode(",", $replacements);
        }
    }
}