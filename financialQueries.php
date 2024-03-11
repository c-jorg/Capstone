<?php
//$table = $GET['table'];
//$year = $GET['year'];
//$year1 = $year + 1;
$sqli = new mysqli('localhost:3306','root','','Research');
//temporarily not used while other pages are still in works$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "'.$year.'-04-01" AND "'.$year1.'-03-31"';
$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "2022-04-01" AND "2023-03-31"';
$contractorYear = ""; //unfinished

$result = mysqli_query($sqli,$fundingYear);

if($result){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            echo "\n".stripslashes($row['entity_id'])." ".stripslashes($row['project_code'])." ".stripslashes($row['funding_amt'])." ".stripslashes($row['date_given'])." ".stripslashes($row['frequency'])." \n";
        }
    }
}