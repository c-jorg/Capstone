<html> <!-- Original Version Created By Mustafa -->
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <title>Funders</title>
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
<h1>Funders</h1>
<table>
  <tr>
  	<!--<th>Funder Salutation</th>
    <th>Funder First Name</th>
    <th>Funder Last Name</th>-->
    <th>Funder Company</th>
    <th>Funder Email</th> <!-- entity table email -->
    <th>Project Code</th> <!-- projectcode -->
    <th>Project Name</th> <!-- title -->
    <th>Date Received</th> <!-- dateReceived -->
    <th>Frequency</th> <!-- depending on int value, Yearly or One-Time  -->
    <th>Funding Amount</th> <!-- totalFunding -->
  </tr>
<?php

$sqli = new mysqli('localhost:3306','root','','Research');
$fullquery = "SELECT e.company,
              e.email,
              f.project_code,
              p.title,
              f.date_given,
              f.frequency,
              f.funding_amt
              FROM Funders f, Entities e, Projects p
              WHERE e.id = f.entity_id AND f.project_code = p.project_code
              ORDER BY f.date_given DESC";

$result = mysqli_query($sqli, $fullquery);
if(mysqli_num_rows($result) !== 0){
  while ($row = mysqli_fetch_array($result)) {
    //$salutation = stripslashes($row['salutation']);
    //$firstname = stripslashes($row['first_name']);
    //$lastname = stripslashes($row['last_name']);
    $company = stripslashes($row['company']);
    $email = stripslashes($row['email']);
    $projectCode = stripslashes($row['project_code']);
    $projectTitle = stripslashes($row['title']);
    $dateGiven = stripslashes($row['date_given']);
    //$frequency = stripslashes($row['frequency']);
    $fundingAmt = stripslashes($row['funding_amt']);

    if(stripslashes($row['frequency'] == 1)){
      $frequency = 'One-Time';
    }else if(stripslashes($row['frequency'] == 2)){
      $frequency = 'Yearly';
    }
    //project page link is WIP... send project_code via GET...
    $entry = "<tr>
                <td>".$company."</td>
                <td>".$email."</td>
                <td>".$projectCode."</td>
                <td><a href='projectPage.php'>".$projectTitle."</a></td>
                <td>".$dateGiven."</td>
                <td>".$frequency."</td>
                <td>$".$fundingAmt."</td>
              </tr>";
    echo $entry;
  }
}
?>
</table>
</body>
</html>





