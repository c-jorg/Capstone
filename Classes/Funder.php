<?php

namespace Classes;

class Funder {

    public $entity;
    public $project;
    public $funding_amt, $funder_end_date;
    public $date_given;
    private $mysqli;
    private $database = "Research";
    private $table = "Funders";

    public function __construct($entity, $project) {
        $this->entity = $entity;
        $this->project = $project;
    }

    public function __toString(): string {
        return "Funder[entity=" . $this->entity
                . ", project=" . $this->project
                . ", funding_amt=" . $this->funding_amt
                . ", funder_end_date=" . $this->funder_end_date
                . ", date_given=" . $this->date_given
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
        $query = "INSERT INTO $this->table "
                . "VALUES ('{$this->entity->id}',"
                . "'{$this->project->project_code}',"
                . "$this->funding_amt,"
                . "$this->date_given,"
                . "$this->funder_end_date"
                . ");";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Funder record has been saved!";
        } else {
            echo "Error while saving record";
        }
        $this->closeConnection();
    }

    public function update($newEntity, $project, $funding_amt, $date_given, $funder_end_date) {
        $this->delete();
        $this->entity = $newEntity;
        $this->project = $project;
        $this->funding_amt = $funding_amt;
        $this->date_given = $date_given;
        $this->funder_end_date = $funder_end_date;
        $this->insert();
    }

    public function delete() {
        $this->openConnection();
        $query = "DELETE FROM $this->table WHERE entity_id = '{$this->entity->id}' AND project_code = '{$this->project->project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Funder Deleted";
        } else {
            echo "Funder Not Found";
        }
        $this->closeConnection();
    }

    public function load() {
        $this->openConnection();
        $query = "SELECT * FROM {$this->table} WHERE entity_id = '{$this->entity->id}' AND project_code = '{$this->project->project_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $this->funding_amt = $data['funding_amt'];
            $this->date_given = $data['date_given'];
            $this->funder_end_date = $data['end_date'];
        }
        $this->closeConnection();
    }

    public static function getIds($project) {
        $check = new Funder(new Entity(), $project);
        $check->openConnection();
        $query = "SELECT entity_id AS id FROM {$check->table} WHERE project_code = '{$project->project_code}';";
        $result = mysqli_query($check->mysqli, $query) or die(mysqli_error($check->mysqli));
        if ($result) {
            $funderId = [];
            while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                array_push($funderId, $data['id']);
            }
            $check->closeConnection();
            return $funderId;
        }
    }

    public static function getNumOfFunders($project) {
        $check = new Funder(new Entity(), $project);
        $check->openConnection();
        $query = "SELECT count(*) AS count FROM {$check->table} WHERE project_code = '{$project->project_code}';";
        $result = mysqli_query($check->mysqli, $query) or die(mysqli_error($check->mysqli));
        if ($result) {
            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $check->closeConnection();
            return $data['count'];
        }
    }
}

?>