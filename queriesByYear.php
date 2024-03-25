<?php
$start = $_GET['start'];
$end = $_GET['end'];
$query = $_GET['query'];
$sqli = new mysqli('localhost:3306','root','','Research');
$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "'.$start.'" AND "'.$end.'"';
$file = fopen("output.txt","w");

//echo $start;
//echo $end;
//$headers = array("First Name", "Last Name", "Email", "Student Type", "Title", "Project Code", "Stage", "Type", "Start Date", "End Date");
if($query == "fundingByYear"){
    $result = mysqli_query($sqli,$fundingYear);
    if ($result && mysqli_num_rows($result) > 0) {
        $headers = array("Project Code", "Funding Amount", "Date Received", "Date Finished");
        fputcsv($file, $headers);
        while ($row = mysqli_fetch_assoc($result)) {
            array_splice($row, 0, 1);
            fputcsv($file, $row);
        }
    }
}
fclose($file);


?>