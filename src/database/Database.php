<?php

class Database {
    
    private $dbhost = 'oniddb.cws.oregonstate.edu';
    private $dbname = 'bensonre-db';
    private $dbuser = 'bensonre-db';
    private $dbpass = 'AM8sgjoZzOQxVAeS';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $conn = new PDO('mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname, $this->dbuser, $this->dbpass);
            $this->conn-setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        return $this->conn;
    }
}

?>