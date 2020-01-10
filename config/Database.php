<?php
  class Database {
    // DB Params
    private $host = 'mysqlsvr70.world4you.com';
    private $db_name = '5166141db1';
    private $username = 'sql7063470';
    private $password = '9q+4zcu';
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
