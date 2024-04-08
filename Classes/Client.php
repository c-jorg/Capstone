<?php
namespace Classes;

include 'loginchecker.php';

class Client {

    public $entity;
    public $project;
    private $mysqli;
    private $database = "Research";
    private $table = "Clients";

    public function __construct($entity, $project) {
        $this->entity = $entity;
        $this->project = $project;
    }
    
    public function __toString(): string {
        return "Client[entity=" . $this->entity
                . ", project=" . $this->project
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
        $query = "INSERT INTO $this->table VALUES ('{$this->entity->id}','{$this->project->project_code}');";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Client has been saved!";
        } else {
            echo "Error while saving Client";
        }
        $this->closeConnection();
    }

    public function update($entity, $project) {
        $this->delete();
        $this->entity = $entity;
        $this->project = $project;
        $this->insert();
        
    }

    public function delete() {
    	$this->openConnection();
        $query = "DELETE FROM $this->table WHERE entity_id = '{$this->entity->id}' AND project_code = '{$this->project->project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Client Deleted";
        } else {
            echo "Client Not Found";
        }
        $this->closeConnection();
    }

    public static function getIds($project) {
        $check = new Client(new Entity(), $project);
        $check->openConnection();
        $query = "SELECT entity_id AS id FROM {$check->table} WHERE project_code = '{$project->project_code}';";
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