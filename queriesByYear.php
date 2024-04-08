<?php include 'loginchecker.php';?>

<?php
$start = $_GET['start'];
$end = $_GET['end'];
$query = $_GET['query'];
$sqli = new mysqli('localhost:3306','root','','Research');
$fundingYear = 'SELECT * FROM Funders WHERE date_given BETWEEN "'.$start.'" AND "'.$end.'"';
$projectsByYear = '
SELECT project_code, title, stage, type, start_date, end_date, status FROM PROJECTS
WHERE 
	start_date BETWEEN "'.$start.'" AND "'.$end.'" OR
	end_date BETWEEN "'.$start.'" AND "'.$end.'"
ORDER BY start_date;';
$contractorsYear = "
SELECT e.company, e.email, c.activity_code, p.project_code, p.title, p.stage, p.type, a.start_date, a.end_date
FROM Contractors c, Projects p, Activities a, Entities e
WHERE c.activity_code = a.activity_code AND
	c.entity_id = e.id AND
	a.project_code = p.project_code AND
	a.activity_code IN (SELECT activity_code FROM Activities WHERE start_date BETWEEN '".$start."' AND '".$end."' OR
	 end_date BETWEEN '".$start."' AND '".$end."')";
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
}else if($query == 'projectsByYear'){
    $result = mysqli_query($sqli, $projectsByYear);
    if($result && mysqli_num_rows($result) > 0){
        $headers = array("Project Code","Project Title","Stage","Type","Start Date","End Date", "Status");
        fputcsv($file, $headers);
        while($row = mysqli_fetch_assoc($result)){
            fputcsv($file, $row);
        }
    }
}else if($query == 'contractorsByYear'){
    $result = mysqli_query($sqli, $contractorsYear);
    if($result && mysqli_num_rows($result) > 0){
        $headers = array("Company", "Email", "Activity Code", "Project Code", "Project Title", "Stage", "Type", "Start Date", "End Date");
        fputcsv($file, $headers);
        while($row = mysqli_fetch_assoc($result)){
            fputcsv($file, $row);
        }
    }
}
fclose($file);


?>