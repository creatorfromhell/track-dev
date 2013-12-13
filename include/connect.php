<?php
/**
 * Created by Daniel Vidmar.
 * Date: 12/13/13
 * Time: 9:30 AM
 * Version: Alpha 1
 * Last Modified: 12/13/13 at 10:55 AM
 * Last Modified by Daniel Vidmar.
 */

//Include the configuration class.
require_once("config.php");
class Connect {

    //Instance of the Configuration Class
    private $configuration;

    //Table prefix variable
    public $prefix;

    //Connection with the DB
    public $connection;

    //connect to the database in the constructor
    public function __construct() {
        $this->configuration = new Configuration();
        $host = $this->configuration->config["database"]["db_host"];
        $user = $this->configuration->config["database"]["db_username"];
        $pass = $this->configuration->config["database"]["db_password"];
        $db = $this->configuration->config["database"]["db_name"];
        $this->prefix = $this->configuration->config["database"]["db_prefix"];
        $this->connection = new mysqli($host, $user, $pass, $db);
    }

    //close the connection in the destructor
    public function __destruct() {
        $this->connection->close();
    }
}
?>