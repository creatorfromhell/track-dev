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

    /**
     * @var
     */
    public $languageinstance;

    /**
     * @var array
     */
    private static $shortcuts = array("%user", "%project", "%list", "%theme", "%none");
    /**
     * @var array
     */
    private $replacements;

    /**
     * @var
     */
    private $dateFormat;

    /**
     * @var array
     */
    private $blacklist;
    /**
     * @var array
     */
    private $blacklist_replacements;

    /**
     * @param $user
     * @param $project
     * @param $list
     * @param $config
     * @param $language
     */
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

    /**
     * @param $string
     * @return mixed
     */
    public function replace($string) {
        return $this->removeBlacklistWords($this->replaceShortcuts($string));
    }

    /**
     * @param $string
     * @return mixed
     */
    public function replaceShortcuts($string) {
        return str_ireplace(self::$shortcuts, $this->replacements, $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    public function removeBlacklistWords($string) {
        return str_ireplace($this->blacklist, $this->blacklist_replacements, $string);
    }

    /**
     * @param $date
     * @return mixed
     */
    public function formatDate($date) {
        $d = explode(" ", $date);
        $date_parts = explode("-", $d[0]);

        $replace = array("d", "m", "y");
        $replacements = array($date_parts[2], $date_parts[1], $date_parts[0]);
        return str_ireplace($replace, $replacements, $this->dateFormat);
    }

    /**
     *
     */
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