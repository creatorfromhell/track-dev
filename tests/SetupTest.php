<?php
/**
 * Created by Daniel Vidmar.
 * Date: 11/14/14
 * Time: 12:06 AM
 * Version: Beta 2
 * Last Modified: 11/14/14 at 12:06 AM
 * Last Modified by Daniel Vidmar.
 */

include_once "test-utils.php";
class SetupTest extends PHPUnit_Framework_TestCase {

    public function testSQLSetup() {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=trackr_tests", "root", "");
        $queries = parseQueries("travis-ci-tables.sql");
        foreach($queries as &$query) {
            $pdo->query($query);
            echo $query;
        }
    }
}