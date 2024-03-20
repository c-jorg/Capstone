<?php
$start = $_GET['start'];
//$year = 2022;
$end = $_GET['end'];
//$query = $_GET['query'];
$sqli = new mysqli('localhost:3306','root','','Research');
//temporarily not used while other pages are still in works$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "'.$year.'-04-01" AND "'.$year1.'-03-31"';
$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "'.$start.'" AND "'.$end.'"';
$contractorYear = ""; //unfinished

$result = mysqli_query($sqli,$fundingYear);
$file = fopen("output.txt","w");

//echo $start;
//echo $end;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        //echo " $" . stripslashes($row['funding_amt']) . "";
        
        echo "".stripslashes($row['entity_id'])." ".stripslashes($row['project_code'])." ".stripslashes($row['funding_amt'])." ".stripslashes($row['date_given'])." ".stripslashes($row['frequency'])."";
        array_splice($row, 0, 1);
        fputcsv($file, $row);
    }
}

fclose($file);


?>