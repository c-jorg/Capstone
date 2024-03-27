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
              e.category
              FROM Entities e, Researchers r
              WHERE e.id = r.entity_id";

$result = mysqli_query($sqli, $fullquery);
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

    /*
    if(stripslashes($row['manager']) !== 'NULL'){
        $manager = stripslashes($row['managerPro']);
    }else if(stripslashes($row['principal']) !== 'NULL'){
        $manager = stripslashes($row['principalAct']);
    }
    */

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





