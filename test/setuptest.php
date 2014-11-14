<?php
/**
 * Created by Daniel Vidmar.
 * Date: 11/13/14
 * Time: 9:09 PM
 * Version: Beta 2
 * Last Modified: 11/13/14 at 9:09 PM
 * Last Modified by Daniel Vidmar.
 */
include_once "test-utils.php";
require_once("PHPUnit/Autoload.php");

class SetupTest extends PHPUnit_Framework_TestCase {
    function testReadSQLFile() {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=trackr_tests", "root", "");
        $queries = parseQueries("travis-ci-tables.sql");
        foreach($queries as &$query) {
            $pdo->query($query);
            echo $query;
        }
    }
}
?>