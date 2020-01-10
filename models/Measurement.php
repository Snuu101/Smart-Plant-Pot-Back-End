<?php
  class Measurement {
    // DB Stuff
    private $conn;
    private $table = 'measurements';

    // Properties
    public $id;
    public $date;
    public $plant_id;
    public $value;
    public $unit;
    public $type;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get measurements
    public function read() {
      // Create query
      $query = '
      SELECT
        id,
        date,
        plant_id,
        unit,
        value,
        type
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

    // Get measurements by plant_id
    public function read_by_plant() {
      // Create query
      $query = '
      SELECT
        id,
        date,
        plant_id,
        unit,
        value,
        type
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

    // Get Single Measurement
    public function read_single(){
      // Create query
      $query = '
        SELECT
          id,
          date,
          plant_id,
          unit,
          value,
          type
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
      $this->type = $row['type'];
    }

  // Create Measurement
  public function create() {
    // Create Query
    $query = '
    INSERT INTO ' .
      $this->table . '
    SET
      plant_id = :plant_id,
      unit = :unit,
      value = :value,
      type = :type
    ';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->plant_id = htmlspecialchars(strip_tags($this->plant_id));
  $this->unit = htmlspecialchars(strip_tags($this->unit));
  $this->value = htmlspecialchars(strip_tags($this->value));
  $this->type = htmlspecialchars(strip_tags($this->type));

  // Bind data
  $stmt-> bindParam(':plant_id', $this->plant_id);
  $stmt-> bindParam(':unit', $this->unit);
  $stmt-> bindParam(':value', $this->value);
  $stmt-> bindParam(':type', $this->type);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Update Measurement
  public function update() {
    // Create Query
    $query = '
    UPDATE ' .
      $this->table . '
    SET
      plant_id = :plant_id,
      unit = :unit,
      value = :value,
      type = :type
    WHERE
      id = :id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->plant_id = htmlspecialchars(strip_tags($this->plant_id));
  $this->unit = htmlspecialchars(strip_tags($this->unit));
  $this->value = htmlspecialchars(strip_tags($this->value));
  $this->type = htmlspecialchars(strip_tags($this->type));

  // Bind data
  $stmt-> bindParam(':id', $this->id);
  $stmt-> bindParam(':plant_id', $this->plant_id);
  $stmt-> bindParam(':unit', $this->unit);
  $stmt-> bindParam(':value', $this->value);
  $stmt-> bindParam(':type', $this->type);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Delete Measurement
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
