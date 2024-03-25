<?php
$query = $_GET['query'];
$sqli = new mysqli('localhost:3306','root','','Research');
$file = fopen("output.txt","w");
$showAllStudents = 
'SELECT e.first_name, e.last_name, e.email, e.category, p.title, p.project_code, p.stage, p.type, p.start_date, p.end_date
FROM Projects p, Entities e, Researchers r, Activities a
WHERE 
	(e.category NOT IN ("non-student") AND
	e.id = r.entity_id AND
	r.activity_code = a.activity_code AND
	a.project_code = p.project_code)
ORDER BY e.last_name';
$showAllStudentsNotInProjects ='
SELECT first_name, last_name, e.email, category
FROM Entities e, Researchers r
WHERE 
	e.category NOT IN ("non-student") AND
	e.id NOT IN (SELECT entity_id FROM Researchers)
GROUP BY e.email
ORDER BY e.last_name
';
$showAllResearchers = '
Select e.first_name, e.last_name, e.email, p.title, p.project_code, p.stage, p.type, p.start_date, p.end_date
FROM Projects p, Entities e, Researchers r, Activities a 
WHERE
	e.category LIKE "non-student" AND
	e.id = r.entity_id AND
	r.activity_code = a.activity_code AND
	a.project_code = p.project_code
ORDER BY e.last_name';

if($query == "allStudents"){
    $result = mysqli_query($sqli,$showAllStudents);
    if ($result && mysqli_num_rows($result) > 0) {
        $headers = array("First Name","Last Name","email","Type of Student","Project Title","Project Code","Stage","Type","Start Date","End Date");
        fputcsv($file,$headers);
        while($row = mysqli_fetch_assoc($result)){
            fputcsv($file,$row);
        }
    }
    $secondResult = mysqli_query($sqli,$showAllStudentsNotInProjects);
    if($secondResult && mysqli_num_rows($secondResult) > 0){
        while($row = mysqli_fetch_assoc($secondResult)){
            fputcsv($file,$row);
        }
    }
}else if($query == "allResearchers"){
    $result = mysqli_query($sqli,$showAllResearchers);
    if($result && mysqli_num_rows($result) > 0){
        $headers = array("First Name","Last Name","Email","Project Title","Project Code","Stage","type","Start Date","End Date");
        fputcsv($file,$headers);
        while($row = mysqli_fetch_assoc($result)){
            fputcsv($file,$row);
        }
    }
}

fclose($file);
?>