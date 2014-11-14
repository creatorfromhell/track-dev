<?php
/**
 * Created by Daniel Vidmar.
 * Date: 11/13/14
 * Time: 10:31 PM
 * Version: Beta 2
 * Last Modified: 11/13/14 at 10:31 PM
 * Last Modified by Daniel Vidmar.
 */

//Our required test filed & includes
require_once("setuptest.php");

class TrackrTest extends \PHPUnit_Framework_TestCase {

    public function testSetup() {
        echo "Preparing to test setup methods....";
        $setup = new SetupTest();
        echo "Testing ReadSQLFile Method...";
        $setup->testReadSQLFile();
        echo "Finished testing setup methods....";
    }
}
?>