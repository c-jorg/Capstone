<html> <!-- Original Version Created By Mustafa -->
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <title>Clients</title>
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
<h1>Clients</h1>
<table>
  <tr>
    <th>Client Name</th> <!-- company -->
    <th>Client Email</th> <!-- email -->
    <th>Project Code</th> <!-- projectcode -->
    <th>Project Name</th> <!-- title -->
  </tr>
<?php

$sqli = new mysqli('localhost:3306','root','','Research');
$fullquery = "SELECT
              e.company,
              e.first_name,
              e.last_name,
              e.salutation,
              e.email,
              c.project_code,
              p.title
              FROM Entities e, Clients c, Projects p
              WHERE e.id = c.entity_id AND
              p.project_code = c.project_code";

$result = mysqli_query($sqli, $fullquery);
if(mysqli_num_rows($result) !== 0){
  while ($row = mysqli_fetch_array($result)) {
    $companyName = stripslashes($row['company']);
    $email = stripslashes($row['email']);
    $projectCode = stripslashes($row['project_code']);
    $projectName = stripslashes($row['title']);

    if($companyName == NULL || $companyName == ''){
      $companyName = stripslashes($row['salutation'] + ' ' + stripslashes($row['first_name']) + ' ' + stripslashes($row['last_name']));
    }

    //project page link is WIP... send project_code via GET...
    $entry = "<tr>
                <td>".$companyName."</td>
                <td>".$email."</td>
                <td>".$projectCode."</td>
                <td><a href='projectPage.php'>".$projectName."</a></td>
              </tr>";
    echo $entry;
  }
}
?>
</table>
</body>
</html>





