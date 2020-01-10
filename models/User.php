<?php
  class User {
    // DB stuff
    private $conn;
    private $table = 'users';

    // User Properties
    public $id;
    public $user_name;
    public $email;
    public $password;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Users
    public function read() {
      // Create query
      $query = '
      SELECT
        id,
        user_name,
        email,
        password
      FROM
        ' . $this->table . '
      ORDER BY
        id ASC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single User
    public function read_single() {
          // Create query
          $query = '
          SELECT
            id,
            user_name,
            email,
            password
          FROM
            ' . $this->table . '
          WHERE
            id = ?
          LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->user_name = $row['user_name'];
          $this->email = $row['email'];
          $this->password = $row['password'];
    }

    // Create User
    public function create() {
          // Create query
          //":title" --> named parameter in PDO
          $query = '
          INSERT INTO '
            . $this->table . '
          SET
            user_name = :user_name,
            email = :email,
            password = :password
          ';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->user_name = htmlspecialchars(strip_tags($this->user_name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->password = htmlspecialchars(strip_tags($this->password));

          // Bind data
          $stmt->bindParam(':user_name', $this->user_name);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':password', $this->password);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update User
    public function update() {
          // Create query
          $query = '
          UPDATE
          ' . $this->table . '
          SET
            user_name = :user_name,
            email = :email,
            password = :password
          WHERE
            id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->user_name = htmlspecialchars(strip_tags($this->user_name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->password = htmlspecialchars(strip_tags($this->password));

          // Bind data
          $stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':user_name', $this->user_name);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':password', $this->password);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Delete User
    public function delete() {

      // Create query
      $query = '
      DELETE FROM
        ' . $this->table . '
      WHERE
        id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    //set User id
    public function setId($id)
    {
      $this->id = $id;
    }
    //get User id
    public function getId()
    {
      return $this->id;
    }

    //set User name
    public function setUser_name($user_name)
    {
      $this->user_name = $user_name;
    }
    //get User name
    public function getUser_name()
    {
      return $this->user_name;
    }

    //set User email
    public function setEmail($email)
    {
      $this->email = $email;
    }
    //get User email
    public function getEmail()
    {
      return $this->email;
    }

    //set User password
    public function setPassword($password)
    {
      $this->password = $password;
    }
    //get User password
    public function getPassword()
    {
      return $this->password;
    }

  }
