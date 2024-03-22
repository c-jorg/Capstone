<?php

class Project {

    public $project_code; //primary key
    public $title, $description, $stage, $type;
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
                . ", start_date=" . $this->start_date
                . ", end_date=" . $this->end_date
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

    public function createProject() {
        $query = "INSERT INTO $this->table "
                . "VALUES ('$this->project_code',"
                . "'$this->title',"
                . "'$this->description',"
                . "'$this->stage',"
                . "'$this->type',"
                . "$this->start_date,"
                . "$this->end_date);";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Project created";
        } else {
            echo "Error while saving Project";
        }
    }

    public function updateProject() {
        $query = "UPDATE $this->table "
                . "SET title = '$this->title',"
                . "description = '$this->description', "
                . "stage = '$this->stage',"
                . "type = '$this->type',"
                . "start_date = '$this->start_date',"
                . "end_date = '$this->end_date' "
                . "WHERE project_code = '$this->project_code';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Project has been updated";
        }
    }

    public function getProject($project_code) {
        $query = "SELECT * FROM {$this->table} WHERE project_code = {$project_code};";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result->num_rows == 1) {
            $this->project_code = $project_code;
            $this->setProject($result);
        } else {
            echo "Project Not Found";
        }
    }

    public function setProject($result) {
        $project = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $this->title = $project['title'];
        $this->description = $project['description'];
        $this->stage = $project['stage'];
        $this->type = $project['type'];
        $this->start_date = $project['start_date'];
        $this->end_date = $project['end_date'];
    }

    public function deleteProject($project_code) {
        $query = "DELETE FROM $this->table WHERE project_code = '{$project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Project {$project_code} Deleted";
        } else {
            echo "Project Not Found";
        }
    }
    
}

?>