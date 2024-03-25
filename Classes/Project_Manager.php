<?php

class Project_Manager {

    public $entity;
    public $project;
    private $mysqli;
    private $database = "Research";
    private $table = "Project_Managers";

    public function __construct($entity, $project) {
        $this->entity = $entity;
        $this->project = $project;
    }
    
    public function __toString(): string {
        return "Project_Manager[entity=" . $this->entity
                . ", project=" . $this->project
                . ", database=" . $this->database
                . ", table=" . $this->table
                . "]";
    }

    public function openConnection() {
        $this->mysqli = new mysqli("localhost", "root", "letmein", $this->database);
        if (mysqli_connect_errno()) {
            echo "Error connecting to the Database";
            exit();
        }
    }

    public function closeConnection() {
        mysqli_close($this->mysqli);
    }

    public function insertManager() {
        $query = "INSERT INTO $this->table VALUES ('{$this->entity->id}','{$this->project->project_code}');";
        echo $query;
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Manager has been saved!";
        } else {
            echo "Error while saving Manager";
        }
    }

    public function updateManager($newEntity, $project) {
        $this->openConnection();
        $this->deleteManager();
        $this->entity = $newEntity;
        $this->project = $project;
        $this->insertManager();
        $this->closeConnection();
    }

    public function deleteManager() {
        $query = "DELETE FROM {$this->table} WHERE project_code = '{$this->project->project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Manager Deleted";
        } else {
            echo "Manager Not Found";
        }
    }

    public static function managerId($project) {
        $check = new Project_Manager(new Entity(), $project);
        $check->openConnection();
        $query = "SELECT entity_id AS id FROM {$check->table} WHERE project_code = {$project->project_code};";
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