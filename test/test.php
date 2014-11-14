<?php
/**
 * Created by Daniel Vidmar.
 * Date: 11/13/14
 * Time: 10:50 PM
 * Version: Beta 2
 * Last Modified: 11/13/14 at 10:50 PM
 * Last Modified by Daniel Vidmar.
 */
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require_once(__DIR__.'/../vendor/autoload.php');
}
require_once("trackrtest.php");


$test = new TrackrTest();
$test->testSetup();

?>