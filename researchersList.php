<html> <!-- Original Version Created By Mustafa -->
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <title>Researchers</title>
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
<h1>Researchers</h1>
<table>
  <tr>
    <th>Researcher Name</th>
    <th>Researchers Email</th> <!-- entity table email -->
    <th>Student Status</th> <!-- category -->
    <th>Principal Researcher Of...</th> <!-- principal researcher entry -->
    <th>Project Manager Of...</th> <!-- project manager entry -->
  </tr>
<?php

$sqli = new mysqli('localhost:3306','root','','Research');

/*
$fullquery = "SELECT e.first_name,
              e.last_name,
              e.salutation,
              e.email,
              e.category,
              NVL(m.entity_id, 'NULL') manager,
              NVL(m.project_code, 'NULL') managerPro,
              NVL(p.entity_id, 'NULL') principal,
              NVL(p.activity_code, 'NULL') principalAct
              FROM Entities e, Researchers r, Project_Managers m, Principal_Researchers p
              WHERE e.id = r.entity_id";
*/

$fullquery = "SELECT e.first_name,
              e.last_name,
              e.salutation,
              e.email,
              e.category,
              e.id
              FROM Entities e, Researchers r
              WHERE e.id = r.entity_id";

$managerQuery = "SELECT m.entity_id, m.project_code
                 FROM Project_Managers m, Researchers r
                 WHERE r.entity_id = m.entity_id";

$principalQuery = "SELECT p.entity_id, p.activity_code
                   FROM Principal_Researchers p, Researchers r
                   WHERE r.entity_id = p.entity_id";

$result = mysqli_query($sqli, $fullquery);
$managerResult = mysqli_query($sqli, $managerQuery);
$principalResult = mysqli_query($sqli, $principalQuery);
if(mysqli_num_rows($result) !== 0){
  while ($row = mysqli_fetch_array($result)) {
    $sal = stripslashes($row['salutation']);
    $first = stripslashes($row["first_name"]);
    $last = stripslashes($row["last_name"]);
    $name = $sal . ' ' . $first . ' ' . $last;
    
    $email = stripslashes($row['email']);
    $status = stripslashes($row['category']);

    $manager = 'N/A';
    $principal = 'N/A';

    $id = stripslashes($row['id']);
    if(mysqli_num_rows($managerResult) !== 0){
        while ($managerRow = mysqli_fetch_array($managerResult)) {
            $managerCheck = stripslashes($managerRow['entity_id']);
            if($managerCheck == $id){
                $code = stripslashes($managerRow['project_code']);
                $manager = "Project Code: " . stripslashes($managerRow['project_code']);
                $manager = "<a href='projectPage.php?project_code=\"".$code."\"'>" . $manager;
            }
        }
    }

    if(mysqli_num_rows($principalResult) !== 0){
        while ($principalRow = mysqli_fetch_array($principalResult)) {
            $principalCheck = stripslashes($principalRow['entity_id']);
            if($principalCheck == $id){
                $code = stripslashes($principalRow['activity_code']);
                $principal = "Activity Code: " . stripslashes($principalRow['activity_code']);
                $principal = "<a href='projectPage.php?project_code=\"".$code."\"'>" . $principal;
            }
        }
    }

    $entry = "<tr>
                <td>".$name."</td>
                <td>".$email."</td>
                <td>".$status."</td>
                <td>".$principal."</td>
                <td>".$manager."</td>
              </tr>";
    echo $entry;
  }
}
?>
</table>
</body>
</html>





