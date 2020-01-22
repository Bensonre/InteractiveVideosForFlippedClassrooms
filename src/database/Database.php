<?php

class Database {
    
    private $dbhost = 'secure.oregonstate.edu/oniddb';
    private $dbname = 'bensonre-db';
    private $dbuser = 'bensonre-db';
    private $dbpass = 'AM8sgjoZzOQxVAeS';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:dbname=$this->dbname;host=$this->dbhost";
            $conn = new PDO($dsn, $this->dbuser, $this->dbpass);
            $this->conn-setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        return $this->conn;
    }
}

?>