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
    <th>Code</th>
    <th>Title</th>
    <th>Stage</th>
    <th>Type</th>
    <th>Funders</th>
    <th>Funding Total</th>
    <th>Application Date</th>
    <th>Grant Received Date</th>
    <th>Reporting Date</th>
    <th>Client</th>
    <th>Lead Researcher</th>
  </tr>
<?php
$colors = ["Red", "Yellow", "Green"];
$type = ["Community", "Technical", "Business", "Other"];
$stage = ["Ideation", "Proposal in Progress", "Awaiting Funding", "In Progress", "Completed - Not Signed Off", "Completed - Signed Off"];
for($i = 1; $i < 15; $i++) {
    $randomNum = random_int(100000, 999999);
    $money = number_format($randomNum);
    $entry = "<tr>
                <td bgcolor='{$colors[$i % count($colors)]}'>{$colors[$i % count($colors)]}</td>
                <td>{$randomNum}</td>
                <td><a href='#'>Project{$i}</a></td>
                <td>{$stage[$i % count($stage)]}</td>
                <td>{$type[$i % count($type)]}</td>
                <td>Funder{$i}</td>
                <td>$ {$money}</td>
                <td>2022-03-12</td>
                <td>2022-09-15</td>
                <td>2025-05-07</td>
                <td>ClientName{$i}</td>
                <td>Researcher{$i}</td>
              </tr>";
    echo $entry;
}
?>
</table>
</body>
</html>





