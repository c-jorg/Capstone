<?php 

$result = getEntities();
echo $result;

function getEntities() {
    $result = "";
    $mysqli = mysqli_connect("localhost", "root", "letmein", "Research");
    
    if(mysqli_connect_errno()) {
        echo "Error connecting to the Database";
        exit();
    } else {
        $getEntities_stmt = "SELECT * FROM Entities;";
        echo $getEntities_stmt;
       
        $query = mysqli_query($mysqli, $getEntities_stmt) or die(mysqli_error($mysqli));
        if($query) { $result = parseData($query); }
        
        mysqli_close($mysqli);
    }
    return $result;
}
function parseData($query) {
    $result = "";
    while($q_result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
        if (empty($result)) { $result .= "+"; }
        $result .= $q_result['id'];
        $result .=  " | ";
        $result .=  $q_result['first_name'] ?? ""; 
        $result .=  $q_result['last_name'] ? " " . $q_result['last_name'] : "";
        $result .=  " | ";
        $result .=  $q_result['company'] ?? "";
    }
    return $result;
}
?>