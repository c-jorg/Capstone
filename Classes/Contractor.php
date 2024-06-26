<?php
namespace Classes;


class Contractor {

    public $entity;
    public $activity;
    public $payment;
    public $date_payed;//date
    
    private $mysqli;
    private $database = "Research";
    private $table = "Contractors";

    public function __construct($entity, $activity) {
        $this->entity = $entity;
        $this->activity = $activity;
    }
    
    public function __toString(): string {
        return "Contractor[entity=" . $this->entity
                . ", activity=" . $this->activity
                . ", payment=" . $this->payment
                . ", date_payed=" . $this->date_payed
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

    public function insertContractor() {
    	$this->openConnection();
        $query = "INSERT INTO $this->table "
                . "VALUES ('{$this->entity->id}',"
                . "'{$this->activity->activity_code}',"
                . "$this->payment,"
                . "$this->date_payed"
                . ");";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Contractor has been saved!";
        } else {
            echo "Error while saving Contractor";
        }
        $this->closeConnection();
    }

    public function update($entity, $activity, $payment, $date_payed) {
        $this->delete();
        $this->entity = $entity;
        $this->activity = $activity;
        $this->payment = $payment;
        $this->date_payed = $date_payed;
        $this->insertContractor();
    }

    public function delete() {
    	$this->openConnection();
        $query = "DELETE FROM $this->table WHERE entity_id = '{$this->entity->id}' AND activity_code = '{$this->activity->activity_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Contractor Deleted";
        } else {
            echo "Contractor Not Found";
        }
        $this->closeConnection();
    }
    public function load() {
        $this->openConnection();
    	$query = "SELECT * FROM {$this->table} WHERE entity_id = '{$this->entity->id}' AND activity_code = '{$this->activity->activity_code}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $this->payment = $data['payment'];
            $this->date_payed = $data['date_payed'];
        }
        $this->closeConnection();
    }
    
    public static function getIds($activity) {
        $check = new Contractor(new Entity(), $activity);
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