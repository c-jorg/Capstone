<?php 
    $numOfFunders = random_int(1, 3);
    $numOfClients = random_int(1, 3);
    $numOfCoResearchers = random_int(1, 3);
    $numOfStudents = random_int(1, 3);
    $numOfContractors = random_int(1, 3);
    
?>
<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, 
initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="index.css">
        <script src='header.js'></script>
        <title>Project : 123456</title>
 </head>
 <body onload='displayHeader()'>
  		<div class='header' id='header'></div>
  		<br>
  		<h1>Project : 123456</h1>
  		<br>
  		<fieldset>
  		<legend align="right"><a href="#">Edit</a></legend>		
      		<p id="title">Title:</p>
      		<p id="stage">Stage:</p>
      		<p id="description">Description:</p>
      		<p id="type">Type:</p>
      		<p id="manager">Manager:</p>
      		<p id="startDate">Start Date:</p>
      		<p id="endDate">End Date:</p>
      		<?php 
      		for ($i = 1; $i <= $numOfFunders; $i++) { echo "<p>Funder 
{$i}:</p>"; }
      		?>
  		</fieldset>
  		<br>
  		<h2>Activity : 432</h2>
  		<br>
  		<fieldset>
  		  		<legend align="right"><a 
href="#">Edit</a></legend>
      		<?php 
      		for ($i = 1; $i <= $numOfClients; $i++) { echo "<p>Client 
{$i}:</p>"; }
      		?>
      		<p id="principleResearcher">Principle Researcher:</p>
      		<?php 
      		for ($i = 1; $i <= $numOfCoResearchers; $i++) { echo 
"<p>Co-Researcher {$i}:</p>"; }
      		for ($i = 1; $i <= $numOfStudents; $i++) { echo 
"<p>Student {$i}:</p>"; }
      		for ($i = 1; $i <= $numOfContractors; $i++) { echo 
"<p>Contractor {$i}:</p>"; }
      		?>
  		</fieldset>
  		<br>
  		<h2>Activity : 876</h2>
  		<br>
  		<fieldset>
  		  		<legend align="right"><a 
href="#">Edit</a></legend>
      		<?php 
      		for ($i = 1; $i <= $numOfClients; $i++) { echo "<p>Client 
{$i}:</p>"; }
      		?>
      		<p id="principleResearcher">Principle Researcher:</p>
      		<?php 
      		for ($i = 1; $i <= $numOfCoResearchers; $i++) { echo 
"<p>Co-Researcher {$i}:</p>"; }
      		for ($i = 1; $i <= $numOfStudents; $i++) { echo 
"<p>Student {$i}:</p>"; }
      		for ($i = 1; $i <= $numOfContractors; $i++) { echo 
"<p>Contractor {$i}:</p>"; }
      		?>
  		</fieldset>
  		
 </body>
 </html>
