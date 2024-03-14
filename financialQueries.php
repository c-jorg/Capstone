<?php
$year = $_GET['year'];
//$year = 2022;
$year1 = $year + 1;
//$query = $_GET['query'];
$sqli = new mysqli('localhost:3306','root','','Research');
//temporarily not used while other pages are still in works$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "'.$year.'-04-01" AND "'.$year1.'-03-31"';
$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "'.$year.'-04-01" AND "'.$year1.'-03-31"';
$contractorYear = ""; //unfinished

$result = mysqli_query($sqli,$fundingYear);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        echo " $" . stripslashes($row['funding_amt']) . "";
    }
}