<?php
$sqli = new mysqli('localhost:3306','root','','Research');
$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "2022-04-01" AND "2023-03-31"';

$result = mysqli_query($sqli,$fundingYear);

if($result){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            echo "\n".stripslashes($row['entity_id'])." ".stripslashes($row['project_code'])." ".stripslashes($row['funding_amt'])." ".stripslashes($row['date_given'])." ".stripslashes($row['frequency'])." \n";
        }
    }
}
?>