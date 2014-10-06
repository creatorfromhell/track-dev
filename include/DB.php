<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/6/14
 * Time: 10:30 AM
 * Version: Beta 1
 * Last Modified: 8/6/14 at 10:51 AM
 * Last Modified by Daniel Vidmar.
 */
$pdo = new PDO("mysql:host=".$configuration->config["database"]["db_host"].";dbname=".$configuration->config["database"]["db_name"], $configuration->config["database"]["db_username"], $configuration->config["database"]["db_password"]);
global $pdo;
?>