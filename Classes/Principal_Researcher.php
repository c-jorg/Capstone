<?php
namespace Classes;


class Principal_Researcher {

    public $entity;
    public $activity;
    private $mysqli;
    private $database = "Research";
    private $table = "Principal_Researchers";

    public function __construct($entity, $activity) {
        $this->entity = $entity;
        $this->activity = $activity;
    }
    
    public function __toString(): string {
        return "Principal_Researcher[entity=" . $this->entity
                . ", activity=" . $this->activity
                . ", database=" . $this->database
                . ", table=" . $this->table
                . "]";
    }

    public function openConnection() {
        $this->mysqli = new \mysqli('localhost:3306','root','', $this->database);
        if (mysqli_connect_errno()) {
            echo "Error connecting to the Database";
            exit();
        }
    }

    public function closeConnection() {
        mysqli_close($this->mysqli);
    }

    public function insert() {
    	$this->openConnection();
        $query = "INSERT INTO $this->table VALUES ('{$this->entity->id}','{$this->activity->activity_code}');";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Principal Researcher has been saved!";
        } else {
            echo "Error while saving Principal Researcher";
        }
        $this->closeConnection();
    }

    public function update($entity, $activity) {
        $this->delete();
        $this->entity = $entity;
        $this->activity = $activity;
        $this->insert();
    }

    public function delete() {
    	$this->openConnection();
        $query = "DELETE FROM $this->table WHERE entity_id = '{$this->entity->id}' AND activity_code = '{$this->activity->activity_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Principal Researcher Deleted";
        } else {
            echo "Principal Researcher Not Found";
        }
        $this->closeConnection();
    }

    public static function getIds($activity) {
        $check = new Principal_Researcher(new Entity(), $activity);
        $check->openConnection();
        $query = "SELECT entity_id AS id FROM {$check->table} WHERE activity_code = '{$activity->activity_code}';";
        $result = mysqli_query($check->mysqli, $query) or die(mysqli_error($check->mysqli));
        if ($result) {
            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $check->closeConnection();
            return $data['id'];
        } else {
            $check->closeConnection();
            return 0;
        }
    }
}

?>