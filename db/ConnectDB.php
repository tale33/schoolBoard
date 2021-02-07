<?php

class ConnectDB {

    private string $dsn = 'mysql:dbname=schoolBoard;host=127.0.0.1';
    private string $user = '';
    private string $password = '';
    private PDO $connection;
    private string $errorMessage = '';

    public function __construct() {
        try {
            $this->connection = new PDO($this->dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            $this->errorMessage = 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getConnection() {
        if($this->errorMessage) {
            return $this->errorMessage;
        } else {
            return $this->connection;
        }
    }
}