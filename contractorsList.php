<?php include 'loginchecker.php';?>

<html> <!-- Original Version Created By Mostafa -->
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <title>Contractors</title>
<style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
      text-align: center;
    }

    h1, th {
        font-family: 'Noto Serif';
    }
    </style>
</head>
<body onload='displayHeader()'>
  <div class='header' id='header'></div>
<h1>Contractors</h1>
<table>
  <tr>
  	<th>Contractor Name</th> <!-- company -->
    <th>Contractor Email</th> <!-- email -->
    <th>Subproject Code</th> <!-- activity code -->
    <th>Subproject Name</th> <!-- activity title -->
    <th>Date Payed</th> <!-- date payed -->
  </tr>
<?php

$sqli = new mysqli('localhost:3306','root','','Research');
$fullquery = "SELECT
              e.first_name,
              e.last_name,
              e.salutation,
              e.company,
              e.email,
              c.activity_code,
              a.title,
              c.date_payed,
              a.project_code
              FROM Entities e, Contractors c, Activities a
              WHERE e.id = c.entity_id AND
              a.activity_code = c.activity_code
              ORDER BY c.date_payed DESC";

$result = mysqli_query($sqli, $fullquery);
if(mysqli_num_rows($result) !== 0){
  while ($row = mysqli_fetch_array($result)) {
    $companyName = stripslashes($row['company']);
    $email = stripslashes($row['email']);
    $activityCode = stripslashes($row['activity_code']);
    $projectName = stripslashes($row['title']);
    $datePayed = stripslashes($row['date_payed']);
    $projectCode = stripslashes($row['project_code']); //will be used for linking activity to project page...

    if($companyName == NULL || $companyName == ''){
      $companyName = stripslashes($row['salutation'] + ' ' + stripslashes($row['first_name']) + ' ' + stripslashes($row['last_name']));
    }

    $entry = "<tr>
                <td>".$companyName."</td>
                <td>".$email."</td>
                <td>".$activityCode."</td>
                <td><a href='projectPage.php?project_code=\"".$projectCode."\"'>".$projectName."</td>
                <td>".$datePayed."</td>
              </tr>";
    echo $entry;
  }
}
?>
</table>
</body>
</html>