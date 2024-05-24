<?php

class Database {
    // Database connection properties
    private $host = "localhost";
    private $username = "root";
    private $password = "037005";
    private $dbname = "auth";
    private $connection;

    // Connect to the database
    public function getConnection() {
        $this->connection = null;

        try {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            // echo ("Connected to the database");
        } catch (mysqli_sql_exception $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
