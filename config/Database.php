<?php
  class Database {
    // DB Params
    private $host = 'insert host url';
    private $db_name = 'insert database name';
    private $username = 'insert user name';
    private $password = 'insert password';
    private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;

      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }
