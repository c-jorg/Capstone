<?php
namespace Classes;


class Activity {

    public $activity_code; //Primary key
    public $title, $description, $notes;
    public $start_date, $end_date; //dates
    public $project;
    
    private $mysqli;
    private $database = "Research";
    private $table = "Activities";

    public function __construct($project, $activity_code = '0') {
        $this->project = $project;
        $this->activity_code = strval($activity_code);
    }
    
    public function __toString(): string {
        return "Activity[activity_code=" . $this->activity_code
                . ", title=" . $this->title
                . ", description=" . $this->description
                . ", stage=" . $this->stage
                . ", type=" . $this->type
                . ", notes=" . $this->notes
                . ", start_date=" . $this->start_date
                . ", end_date=" . $this->end_date
                . ", notes=" . $this. $this->notes
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

    public function create() {
    	$this->openConnection();
        $query = "INSERT INTO $this->table "
                . "VALUES ('$this->activity_code',"
                . "'{$this->project->project_code}',"
                . "'$this->title',"
                . "'$this->description',"
                . "$this->start_date,"
                . "$this->end_date,"
                . "'$this->notes');";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Activity has been saved!";
        } else {
            echo "Error while saving Activity";
        }
        $this->closeConnection();
    }

    public function update() {
    	$this->openConnection();
        $query = "UPDATE $this->table "
                . "SET activity_code = '$this->activity_code',"
                . "project_code = '{$this->project->project_code}',"
                . "title = '$this->title',"
                . "description = '$this->description', "
                . "start_date = $this->start_date,"
                . "end_date = $this->end_date,"
                . "notes = '$this->notes' "
                . "WHERE activity_code = '$this->activity_code';";
        echo $query;
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Activity has been updated successfully";
        }
        $this->closeConnection();
    }

    public function load($activity_code) {
        $this->openConnection();
        $query = "SELECT * FROM $this->table WHERE activity_code = '{$activity_code}' AND project_code = '{$this->project->project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result->num_rows === 1) {
            $this->set($result);
        } else {
            echo "Activity Not Found";
        }
        $this->closeConnection();
    }

    public function set($result) {
        $activity = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $this->title = $activity['title'];
        $this->description = $activity['description'];
        $this->start_date = $activity['start_date'];
        $this->end_date = $activity['end_date'];
        $this->notes = $activity['notes'];
    }

    public function delete($activity_code) {
    	$this->openConnection();
        $query = "DELETE FROM $this->table WHERE activity_code = '{$activity_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result->num_rows == 1) {
            echo "Activity {$activity_code} Deleted";
        } else {
            echo "Activity Not Found";
        }
        $this->closeConnection();
    }
    
    public static function getCodes($project_code) {
        $check = new Activity($project_code);
        $check->openConnection();
        $query = "SELECT activity_code AS code FROM {$check->table} WHERE project_code = '{$project_code}';";
        $result = mysqli_query($check->mysqli, $query) or die(mysqli_error($check->mysqli));
        if ($result) {
            $code = [];
            while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                array_push($code, $data['code']);
            }
            $check->closeConnection();
            return $code;
        } 
    }
}

?>