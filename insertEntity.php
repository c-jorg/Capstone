<?php 
$data = [];
$data[0] = filter_input(INPUT_GET, 'first_name');
$data[1] = filter_input(INPUT_GET, 'last_name');
$data[2] = filter_input(INPUT_GET, 'email');
$data[3] = filter_input(INPUT_GET, 'salutation');
$data[4] = filter_input(INPUT_GET, 'company');
$data[5] = filter_input(INPUT_GET, 'category');

insert($data);

function insert(&$data) {
    $mysqli = mysqli_connect("localhost", "root", "letmein", "Research");
    
    if(mysqli_connect_errno()) {
        echo "Error connecting to the Database";
        exit();
    } else {
        $insert_stmt = "INSERT INTO Entities (first_name, last_name, email, salutation, company, category) ";
        $insert_stmt .= "VALUES ('{$data[0]}','{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}','{$data[5]}');";
       // echo $insert_stmt;
        $insertion = mysqli_query($mysqli, $insert_stmt) or die(mysqli_error($mysqli));
        if($insertion === true) { echo "Entity has been saved!"; }
        else {echo "Error while saving Entity!";}
         
        mysqli_close($mysqli);
    }
}

?>