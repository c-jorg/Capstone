<?php
namespace Classes;

class Researcher {

    public $entity;
    public $activity;
    private $mysqli;
    private $database = "Research";
    private $table = "Researchers";

    public function __construct($entity, $activity) {
        $this->entity = $entity;
        $this->activity = $activity;
    }

    public function __toString(): string {
        return "Researcher[entity=" . $this->entity
                . ", activity=" . $this->activity
                . ", database=" . $this->database
                . ", table=" . $this->table
                . "]";
    }

    public function openConnection() {
        $this->mysqli = new \mysqli("localhost", "root", "", $this->database);
        if (mysqli_connect_errno()) {
            echo "Error connecting to the Database";
            exit();
        }
    }

    public function closeConnection() {
        mysqli_close($this->mysqli);
    }

    public function insertResearcher() {
    	$this->openConnection();
        $query = "INSERT INTO $this->table VALUES ('{$this->entity->id}','{$this->activity->activity_code}','{$this->entity->category}');";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Record has been saved!";
        } else {
            echo "Error while saving record";
        }
        $this->closeConnection();
    }

    public function updateResearcher($entity_id, $project_code, $activity_code) {
        $this->deleteResearcher();
        $this->entity = new Entity($entity_id);
        $this->activity = new Activity($project_code, $activity_code);
        $this->insertResearcher();
    }

    public function deletePrincipalResearcher() {
    	$this->openConnection();
        $query = "DELETE FROM $this->table WHERE entity_id = '{$this->entity->id}' AND activity_code = '{$this->activity->activity_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result->num_rows == 1) {
            echo "Record Deleted";
        } else {
            echo "Record Not Found";
        }
        $this->closeConnection();
    }

    public static function researcherId($activity) {
        $check = new Researcher(new Entity(), $activity);
        $check->openConnection();
        $query = "SELECT entity_id AS id FROM {$check->table} WHERE activity_code = '{$activity->activity_code}';";
        $result = mysqli_query($check->mysqli, $query) or die(mysqli_error($check->mysqli));
        if ($result) {
            $Id = [];
            while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                array_push($Id, $data['id']);
            }
            $check->closeConnection();
            return $Id;
        }
    }
}

?>