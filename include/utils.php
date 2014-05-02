<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Beta 1
 * Last Modified: 12/13/13 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

class Utils {

    public static function getIP() {
        $ip = "";
        if (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"]." ";
        } else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]." ";
        } else if ( isset($_SERVER["HTTP_CLIENT_IP"]) ) {
            $ip = $_SERVER["HTTP_CLIENT_IP"]." ";
        }
        return $ip;
    }

    public static function generateUUID() {
        return sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public static function strContains($string, $word) {
        if (strpos($string, $word) !== false) {
            return true;
        }
        return false;
    }
}
?>