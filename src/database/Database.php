<?php

class Database {
    
    private $dbhost = 'oniddb.cws.oregonstate.edu';
    private $dbname = 'bensonre-db';
    private $dbuser = 'bensonre-db';
    private $dbpass = 'AM8sgjoZzOQxVAeS';
    private $conn;

    public function connect() {
        $this->conn = null;

        $mysqli = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        
        $this->conn = $mysqli;

        return $this->conn;
    }
}

?>