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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <title>Project : 123456</title>
<script>
	function editProject(numOfFunders) {
		const id_array = ['title','stage','description','type','manager','startDate','endDate'];
		for (let i = 1; i <= numOfFunders; i++) {
			id_array.push(`funder${i}`);
		}
		for (let i = 0; i < id_array.length; i++) {
			let text = document.querySelector(`span#${id_array[i]}`).innerHTML;
			if (text == '') {text = "abc" + Math.floor(Math.random() * 100);}
			let input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
			console.log(text);
			console.log(input);
			document.querySelector(`span#${id_array[i]}`).innerHTML = input;
		}
	};
</script>
</head>
<body onload='displayHeader()'>
	<div class='header' id='header'></div>
	<br>
	<h1>Project : 123456</h1>
	<br>
	<fieldset>
	<legend align="right"><a onclick="editProject(<?= $numOfFunders; ?>);return false;" href="#">Edit</a></legend>		
  		<p>Title: <span id="title">ABC</span></p><br>
  		<p>Stage: <span id="stage">DEF</span></p><br>
  		<p>Description: <span id="description">GHI</span></p><br>
  		<p>Type: <span id="type">JKL</span></p><br>
  		<p>Manager: <span id="manager">MNO</span></p><br>
  		<p>Start Date: <span id="startDate">date1</span></p><br>
  		<p>End Date: <span id="endDate">date2</span></p><br>
  		<?php 
  		for ($i = 1; $i <= $numOfFunders; $i++) { echo "<p>Funder {$i}: <span id='funder{$i}'>funding{$i}</span></p><br>"; }
  		?>
	</fieldset>
	<br>
	<h2>Activity : 432</h2>
	<br>
	<fieldset>
	  	<legend align="right"><a href="#">Edit</a></legend>
  		<?php 
  		for ($i = 1; $i <= $numOfClients; $i++) { echo "<p>Client {$i}: <span id='client{$i}'></span></p>"; }
  		?>
  		<p id="principalResearcher">Principal Researcher: <span id='principalResearcher'></span></p>
  		<?php 
  		for ($i = 1; $i <= $numOfCoResearchers; $i++) { echo "<p>Co-Researcher {$i}: <span id='coResearcher{$i}'></span></p>"; }
  		for ($i = 1; $i <= $numOfStudents; $i++) { echo "<p>Student {$i}: <span id='studebt{$i}'></span></p>"; }
  		for ($i = 1; $i <= $numOfContractors; $i++) { echo "<p>Contractor {$i}: <span id='contractor{$i}'></span></p>"; }
  		?>
	</fieldset>
	<br>
	<h2>Activity : 876</h2>
	<br>
	<fieldset>
	  	<legend align="right"><a href="#">Edit</a></legend>
  		<?php 
  		for ($i = 1; $i <= $numOfClients; $i++) { echo "<p>Client {$i}: <span id='client{$i}'></span></p>"; }
  		?>
  		<p id="principalResearcher">Principal Researcher: <span id='principalResearcher'></span></p>
  		<?php 
  		for ($i = 1; $i <= $numOfCoResearchers; $i++) { echo "<p>Co-Researcher {$i}: <span id='coResearcher{$i}'></span></p>"; }
  		for ($i = 1; $i <= $numOfStudents; $i++) { echo "<p>Student {$i}: <span id='studebt{$i}'></span></p>"; }
  		for ($i = 1; $i <= $numOfContractors; $i++) { echo "<p>Contractor {$i}: <span id='contractor{$i}'></span></p>"; }
  		?>
	</fieldset>
 </body>
 </html>