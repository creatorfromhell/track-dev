<?php
/**
 * Created by Daniel Vidmar.
 * Date: 11/14/14
 * Time: 12:06 AM
 * Version: Beta 2
 * Last Modified: 11/14/14 at 12:06 AM
 * Last Modified by Daniel Vidmar.
 */

class TrackrTest extends PHPUnit_Framework_TestCase {

    public function testSetup() {
        echo "Preparing to test setup methods....";
        $setup = new SetupTest();
        echo "Testing ReadSQLFile Method...";
        $setup->testReadSQLFile();
        echo "Finished testing setup methods....";
    }
}