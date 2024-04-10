<?php
namespace Classes;


class Entity {

    public $id; //Primary key
    public $email; //Unique
    public $first_name, $last_name, $salutation, $company, $category;
    
    private $mysqli;
    private $database = "Research";
    private $table = "Entities";

    public function __construct($id = 0) {
        $this->id = $id;
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

    public function __toString(): string {
        return "Entity[id=" . $this->id
                . ", email=" . $this->email
                . ", first_name=" . $this->first_name
                . ", last_name=" . $this->last_name
                . ", salutation=" . $this->salutation
                . ", company=" . $this->company
                . ", category=" . $this->category
                . ", database=" . $this->database
                . ", table=" . $this->table
                . "]";
    }

    public function create() {
    	$this->openConnection();
        $query = "INSERT INTO $this->table (first_name, last_name, email, salutation, company, category) "
                . "VALUES ('$this->first_name',"
                . "'$this->last_name',"
                . "'$this->email',"
                . "'$this->salutation',"
                . "'$this->company',"
                . "'$this->category');";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            $this->id = mysqli_insert_id($this->mysqli);
            echo "Entity has been created";
        } else {
            echo "Error while saving Entity";
        }
        $this->closeConnection();
    }

    public function update() {
    	$this->openConnection();
        $query = "UPDATE $this->table "
                . "SET first_name = '$this->first_name',"
                . "last_name = '$this->last_name',"
                . "email = '$this->email', "
                . "salutation = '$this->salutation',"
                . "company = '$this->company',"
                . "category = '$this->category' "
                . "WHERE id = '$this->id';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Entity has been updated successfully";
        }
        $this->closeConnection();
    }

    public function load($id) {
    	$this->openConnection();
        $query = "SELECT * FROM {$this->table} WHERE id = '{$id}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result->num_rows === 1) {
            echo "Entity Found";
            $this->setEntity($result);
        } else {
            echo "Entity Not Found";
        }
        $this->closeConnection();
    }

    private function setEntity($result) {
        $entity = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $this->id = $entity['id'];
        $this->first_name = $entity['first_name'];
        $this->last_name = $entity['last_name'];
        $this->email = $entity['email'];
        $this->salutation = $entity['salutation'];
        $this->company = $entity['company'];
        $this->category = $entity['category'];
    }

    public function delete($id) {
    	$this->openConnection();
        $query = "DELETE FROM $this->table WHERE id = '{$id}';";
        $result = mysqli_query($this->mysqli, $query) or die(mysqli_error($this->mysqli));
        if ($result) {
            echo "Entity {$id} Deleted";
        } else {
            echo "Entity Not Found";
        }
        $this->closeConnection();
    }
    public function getName() {
        $name = $this->first_name . $this->last_name ? $this->first_name . " " . $this->last_name : "";
        $name .= $name && $this->company ? ", " : "";
        $name .= $this->company ? "{$this->company}" : "";
        $name = $name ? $name : $this->email;
        
        return $name;
    }
}
?>