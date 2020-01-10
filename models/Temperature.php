<?php
  class Temperature {
    // DB Stuff
    private $conn;
    private $table = 'temperatures';

    // Properties
    public $id;
    public $date;
    public $plant_id;
    public $unit;
    public $value;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get temperatures
    public function read() {
      // Create query
      $query = '
      SELECT
        id,
        date,
        plant_id,
        unit,
        value
      FROM
        ' . $this->table . '
      ORDER BY
        date DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get temperatures by plant_id
    public function read_by_plant() {
      // Create query
      $query = '
      SELECT
        id,
        date,
        plant_id,
        unit,
        value
      FROM
        ' . $this->table . '
      WHERE
        plant_id = ?
      ORDER BY
        date DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->plant_id);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Temperature
    public function read_single(){
      // Create query
      $query = '
        SELECT
          id,
          date,
          plant_id,
          unit,
          value
        FROM
          ' . $this->table . '
        WHERE
          id = ?
        LIMIT 0,1
      ';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->date = $row['date'];
      $this->plant_id = $row['plant_id'];
      $this->unit = $row['unit'];
      $this->value = $row['value'];
    }

  // Create Temperature
  public function create() {
    // Create Query
    $query = '
    INSERT INTO ' .
      $this->table . '
    SET
      plant_id = :plant_id,
      unit = :unit,
      value = :value
      ';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->plant_id = htmlspecialchars(strip_tags($this->plant_id));
  $this->unit = htmlspecialchars(strip_tags($this->unit));
  $this->value = htmlspecialchars(strip_tags($this->value));

  // Bind data
  $stmt-> bindParam(':plant_id', $this->plant_id);
  $stmt-> bindParam(':unit', $this->unit);
  $stmt-> bindParam(':value', $this->value);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Update Temperature
  public function update() {
    // Create Query
    $query = '
    UPDATE ' .
      $this->table . '
    SET
      date = :date,
      owner_id = :owner_id,
      unit = :unit,
      value = :value
    WHERE
      id = :id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->date = htmlspecialchars(strip_tags($this->date));
  $this->plant_id = htmlspecialchars(strip_tags($this->plant_id));
  $this->unit = htmlspecialchars(strip_tags($this->unit));
  $this->value = htmlspecialchars(strip_tags($this->value));

  // Bind data
  $stmt-> bindParam(':id', $this->id);
  $stmt-> bindParam(':date', $this->date);
  $stmt-> bindParam(':plant_id', $this->plant_id);
  $stmt-> bindParam(':unit', $this->unit);
  $stmt-> bindParam(':value', $this->value);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Delete Temperature
  public function delete() {
    // Create query
    $query = '
    DELETE FROM
      ' . $this->table . '
    WHERE
      id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
