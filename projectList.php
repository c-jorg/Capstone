<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <title>Projects</title>
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
<h1>Projects</h1>
<h4><a href="./projectPosting.php">+ Create New Project</a></h4>
<table>
  <tr>
  	<th>Status</th>
    <th>Project Code</th>
    <th>Project Name</th>
    <th>Stage</th>
    <th>Project Type</th>
    <th>Start Date</th>
    <th>End Date</th>
  </tr>
<?php

$sqli = new mysqli('localhost:3306','root','','Research');
$fullquery = "SELECT
              p.project_code,
              p.title,
              p.stage,
              p.type,
              p.start_date,
              p.end_date,
              p.status
              FROM Projects p";

$result = mysqli_query($sqli, $fullquery);
if(mysqli_num_rows($result) !== 0){
  while ($row = mysqli_fetch_array($result)) {
    $projectCode = stripslashes($row['project_code']);
    $title = stripslashes($row['title']);
    $stage = stripslashes($row['stage']);
    $type = stripslashes($row['type']);
    $dateStart = stripslashes($row['start_date']);
    $dateEnd = stripslashes($row['end_date']);
    $status = stripslashes($row['status']);

    $color = 'White';
    
    if($status == 'Green'){
      $color = 'Green';
    }else if($status == 'Yellow'){
      $color = 'Yellow';
    }else if($status == 'Red'){
      $color = 'Red';
    }

    $entry = "<tr>
                <td bgcolor='".$color."'>".$status."</td>
                <td>".$projectCode."</td>
                <td><a href='projectPage.php?project_code=\"".$projectCode."\"'>".$title."</td>
                <td>".$stage."</td>
                <td>".$type."</td>
                <td>".$dateStart."</td>
                <td>".$dateEnd."</td>
              </tr>";
    echo $entry;
  }
}
?>
</table>
</body>
</html>





