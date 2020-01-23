<?php
  class Image {
    // DB Stuff
    private $conn;
    private $table = 'images';

    // Properties
    public $id;
    public $date;
    public $plant_id;
    public $path;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Images
    public function read() {
      // Create query
      $query = '
      SELECT
        id,
        date,
        plant_id,
        path
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

    // Get Images by plant_id
    public function read_by_plant() {
      // Create query
      $query = '
      SELECT
        id,
        date,
        plant_id,
        path
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

    // Get Single Image
    public function read_single(){
      // Create query
      $query = '
        SELECT
          id,
          date,
          plant_id,
          path
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
      $this->path = $row['path'];
    }

  // Create Image
  public function create() {
    // Create Query
    $query = '
    INSERT INTO ' .
      $this->table . '
    SET
      plant_id = :plant_id,
      path = :path;

    UPDATE plants
    SET profile_image_id = Last_insert_id()
    WHERE plants.id = (SELECT plant_id from images WHERE id = last_insert_id())
    ';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->plant_id = htmlspecialchars(strip_tags($this->plant_id));
  $this->path = htmlspecialchars(strip_tags($this->path));

  // Bind data
  $stmt-> bindParam(':plant_id', $this->plant_id);
  $stmt-> bindParam(':path', $this->path);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Update Image
  public function update() {
    // Create Query
    $query = '
    UPDATE ' .
      $this->table . '
    SET
      plant_id = :plant_id,
      path = :path
    WHERE
      id = :id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->plant_id = htmlspecialchars(strip_tags($this->plant_id));
  $this->path = htmlspecialchars(strip_tags($this->path));

  // Bind data
  $stmt-> bindParam(':id', $this->id);
  $stmt-> bindParam(':plant_id', $this->plant_id);
  $stmt-> bindParam(':path', $this->path);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Delete Image
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
			