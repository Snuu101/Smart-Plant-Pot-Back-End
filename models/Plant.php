<?php
  class Plant {
    // DB stuff
    private $conn;
    private $table = 'plants';

    // Plant Properties
    public $id;
    public $name;
    public $date_added;
    public $owner_id;
    public $status;
    public $temperature_treshold;
    public $humidity_treshold;
    public $active;
    public $profile_image_id;
    public $type;
    public $curr_temperature;
    public $curr_humidity_soil;
    public $curr_humidity_air;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Plants
    public function read() {
      // Create query
      $query = '
      SELECT u.user_name as user_name,
        p.id,
        p.name,
        p.date_added,
        p.owner_id,
        p.status,
        p.temperature_treshold,
        p.humidity_treshold,
        p.active,
        p.profile_image_id,
        p.type
      FROM
        ' . $this->table . ' p
      LEFT JOIN
        users u ON p.owner_id = u.id
      ORDER BY
        p.date_added DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Plant
    public function read_single() {
          // Create query
          $query = '
            SELECT
              u.user_name as user_name,
              p.id, p.name,
              p.date_added,
              p.owner_id,
              p.status,
              p.temperature_treshold,
              p.humidity_treshold,
              p.active,
              p.profile_image_id,
              p.type
            FROM ' . $this->table . ' p
            LEFT JOIN
              users u ON p.owner_id = u.id
            WHERE
              p.id = ?
            LIMIT 0,1'
          ;

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->name = $row['name'];
          $this->date_added = $row['date_added'];
          $this->owner_id = $row['owner_id'];
          $this->status = $row['status'];
          $this->temperature_treshold = $row['temperature_treshold'];
          $this->humidity_treshold = $row['humidity_treshold'];
          $this->active = $row['active'];
          $this->profile_image_id = $row['profile_image_id'];
          $this->type = $row['type'];
    }

    // Get Plants
    public function read_by_user() {
      // Create query
      $query = '
      SELECT
        id,
        name,
        date_added,
        owner_id,
        status,
        temperature_treshold,
        humidity_treshold,
        active,
        profile_image_id,
        type
      FROM
        ' . $this->table . ' p
      WHERE
        owner_id = ?
      ORDER BY
        id ASC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->owner_id);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Read Plant data and current Measurements
    public function read_start() {
      // Create query
      $query = '
        SELECT
          u.user_name as user_name,
          p.id, p.name,
          p.date_added,
          p.owner_id,
          p.status,
          p.temperature_treshold,
          p.humidity_treshold,
          p.active,
          p.profile_image_id,
          p.type
        FROM ' . $this->table . ' p
        LEFT JOIN
          users u ON p.owner_id = u.id
        WHERE
          p.id = :id
        LIMIT 0,1;

        SELECT
          m1.value as curr_temperature
        FROM
          ' . $this->table . ' p
        LEFT JOIN
          measurements m1 ON m1.plant_id = p.id
        WHERE
          p.id = :id
        AND
          m1.type = \'temperature\'
        ORDER BY
          m1.date DESC
        LIMIT
          0,1;

        SELECT
          m2.value as curr_humidity_air
        FROM
          ' . $this->table . ' p
        LEFT JOIN
          measurements m2 ON m2.plant_id = p.id
        WHERE
          p.id = :id
        AND
          m2.type = \'humidity_air\'
        ORDER BY
          m2.date DESC
        LIMIT
          0,1;

        SELECT
          m3.value as curr_humidity_soil
        FROM
          ' . $this->table . ' p
        LEFT JOIN
          measurements m3 ON m3.plant_id = p.id
        WHERE
          p.id = :id
        AND
          m3.type = \'humidity_soil\'
        ORDER BY
          m3.date DESC
        LIMIT
          0,1;
        '
      ;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(':id', $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //Set properties
      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->date_added = $row['date_added'];
      $this->owner_id = $row['owner_id'];
      $this->status = $row['status'];
      $this->temperature_treshold = $row['temperature_treshold'];
      $this->humidity_treshold = $row['humidity_treshold'];
      $this->active = $row['active'];
      $this->profile_image_id = $row['profile_image_id'];
      $this->type = $row['type'];

      $stmt->nextRowset();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->curr_temperature = $row['curr_temperature'];

      $stmt->nextRowset();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->curr_humidity_air = $row['curr_humidity_air'];

      $stmt->nextRowset();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->curr_humidity_soil = $row['curr_humidity_soil'];

    }

    // Create Plant
    public function create() {
          // Create query
          //":title" --> named parameter in PDO
          $query = 'INSERT INTO ' . $this->table . ' SET name = :name, owner_id = :owner_id, status = :status, temperature_treshold = :temperature_treshold, humidity_treshold = :humidity_treshold, active = :active, profile_image_id = :profile_image_id, type = :type';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
          $this->status = htmlspecialchars(strip_tags($this->status));
          $this->temperature_treshold = htmlspecialchars(strip_tags($this->temperature_treshold));
          $this->humidity_treshold = htmlspecialchars(strip_tags($this->humidity_treshold));
          $this->active = htmlspecialchars(strip_tags($this->active));
          $this->profile_image_id = htmlspecialchars(strip_tags($this->profile_image_id));
          $this->type = htmlspecialchars(strip_tags($this->type));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':owner_id', $this->owner_id);
          $stmt->bindParam(':status', $this->status);
          $stmt->bindParam(':temperature_treshold', $this->temperature_treshold);
          $stmt->bindParam(':humidity_treshold', $this->humidity_treshold);
          $stmt->bindParam(':active', $this->active);
          $stmt->bindParam(':profile_image_id', $this->profile_image_id);
          $stmt->bindParam(':type', $this->type);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Plant
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
            SET
                name = :name,
                owner_id = :owner_id,
                status = :status,
                temperature_treshold = :temperature_treshold,
                humidity_treshold = :humidity_treshold,
                active = :active,
                profile_image_id = :profile_image_id,
                type = :type
            WHERE
                id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
          $this->status = htmlspecialchars(strip_tags($this->status));
          $this->temperature_treshold = htmlspecialchars(strip_tags($this->temperature_treshold));
          $this->humidity_treshold = htmlspecialchars(strip_tags($this->humidity_treshold));
          $this->active = htmlspecialchars(strip_tags($this->active));
          $this->profile_image_id = htmlspecialchars(strip_tags($this->profile_image_id));
          $this->type = htmlspecialchars(strip_tags($this->type));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':owner_id', $this->owner_id);
          $stmt->bindParam(':status', $this->status);
          $stmt->bindParam(':temperature_treshold', $this->temperature_treshold);
          $stmt->bindParam(':humidity_treshold', $this->humidity_treshold);
          $stmt->bindParam(':active', $this->active);
          $stmt->bindParam(':profile_image_id', $this->profile_image_id);
          $stmt->bindParam(':type', $this->type);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Delete Plant
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

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

    //set plant id
    public function setId($id)
    {
      $this->id = $id;
    }
    //get plant id
    public function getId()
    {
      return $this->id;
    }

    //set plant name
    public function setName($name)
    {
      $this->name = $name;
    }
    //get plant name
    public function getName()
    {
      return $this->name;
    }

    //set plant date_added
    public function setDate_added($date_added)
    {
      $this->date_added = $date_added;
    }
    //get plant date_added
    public function getDate_added()
    {
      return $this->date_added;
    }

    //set plant owner_id
    public function setOwner_id($owner_id)
    {
      $this->owner_id = $owner_id;
    }
    //get plant owner_id
    public function getOwner_id()
    {
      return $this->owner_id;
    }

    //set plant status
    public function setStatus($status)
    {
      $this->status = $status;
    }
    //get plant status
    public function getStatus()
    {
      return $this->status;
    }

    //set plant temperature_treshold
    public function setTemperature_treshold($temperature_treshold)
    {
      $this->temperature_treshold = $temperature_treshold;
    }
    //get plant temperature_treshold
    public function getTemperature_treshold()
    {
      return $this->temperature_treshold;
    }

    //set plant humidity_treshold
    public function setHumidity_treshold($humidity_treshold)
    {
      $this->humidity_treshold = $humidity_treshold;
    }
    //get plant humidity_treshold
    public function getHumidity_treshold()
    {
      return $this->humidity_treshold;
    }

    //set plant active
    public function setActive($active)
    {
      $this->active = $active;
    }
    //get plant active
    public function getActive()
    {
      return $this->active;
    }

    //set plant profile_image_id
    public function setProfile_image_id($profile_image_id)
    {
      $this->profile_image_id = $profile_image_id;
    }
    //get plant profile_image_id
    public function getProfile_image_id()
    {
      return $this->profile_image_id;
    }

    //set plant type
    public function setType($type)
    {
      $this->type = $type;
    }
    //get plant type
    public function getType()
    {
      return $this->type;
    }


  }
