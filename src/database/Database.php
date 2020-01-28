<?php

class Database {
    
    private $dbhost = 'fliiped-classroom.mysql.database.azure.com';
    private $dbname = 'capstone';
    private $dbuser = 'PowerRangers@fliiped-classroom';
    private $dbpass = 'Mighty-Morphin';
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