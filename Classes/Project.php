<?php

namespace Classes;


class Project {

    public $project_code; //primary key
    public $title, $description, $stage, $type, $status;
    public $start_date, $end_date; //dates
    private $mysqli;
    private $database = "Research";
    private $table = "Projects";

    public function __construct($project_code) {
        $this->project_code = $project_code;
    }

    public function __toString(): string {
        return "Project[project_code=" . $this->project_code
                . ", title=" . $this->title
                . ", description=" . $this->description
                . ", stage=" . $this->stage
                . ", type=" . $this->type
                . ", status=" . $this->status
                . ", start_date=" . $this->start_date
                . ", end_date=" . $this->end_date
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

    public function create() {
    	$this->openConnection();
        $query = "INSERT INTO $this->table "
                . "VALUES ('$this->project_code',"
                . "'$this->title',"
                . "'$this->description',"
                . "'$this->stage',"
                . "'$this->type',"
                . "$this->start_date,"
                . "$this->end_date,"
                . "'$this->status');";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Project created";
        } else {
            echo "Error while saving Project";
        }
        $this->closeConnection();
    }

    public function update() {
    	$this->openConnection();
        $query = "UPDATE $this->table "
                . "SET title = '$this->title',"
                . "description = '$this->description', "
                . "stage = '$this->stage',"
                . "type = '$this->type',"
                . "start_date = $this->start_date,"
                . "end_date = $this->end_date, "
                . "status= '$this->status' "
                . "WHERE project_code = '$this->project_code';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Project has been updated";
        }
        $this->closeConnection();
    }

    public function load($project_code) {
    	$this->openConnection();
        $query = "SELECT * FROM {$this->table} WHERE project_code = '{$project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            $this->project_code = $project_code;
            $this->setProject($result);
        } else {
            echo "Project Not Found";
        }
        $this->closeConnection();
    }

    private function setProject($result) {
        $project = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $this->title = $project['title'];
        $this->description = $project['description'];
        $this->stage = $project['stage'];
        $this->type = $project['type'];
        $this->start_date = $project['start_date'];
        $this->end_date = $project['end_date'];
        $this->status = $project['status'];
    }

    public function delete($project_code) {
    	$this->openConnection();
        $query = "DELETE FROM $this->table WHERE project_code = '{$project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Project {$project_code} Deleted";
        } else {
            echo "Project Not Found";
        }
        $this->closeConnection();
    }
}

?>