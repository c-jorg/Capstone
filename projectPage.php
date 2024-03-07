<?php 
    $numOfFunders = random_int(1, 3);
    $numOfClients = random_int(1, 3);
    $numOfCoResearchers = random_int(1, 3);
    $numOfStudents = random_int(1, 3);
    $numOfContractors = random_int(1, 3);
    
    $numOfActivities = 5;
    
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
		document.querySelector(`a#editProject`).setAttribute("onclick","return false;");
		const id_array = ['title','stage','description','type','manager','startDate','endDate'];
		for (let i = 1; i <= numOfFunders; i++) {
			id_array.push(`funder${i}`);
		}
		for (let i = 0; i < id_array.length; i++) {
			let text = document.querySelector(`span#${id_array[i]}`).innerHTML;
			if (text == '') {text = "abc" + Math.floor(Math.random() * 100);}
			let input = "";
			if (id_array[i] != 'stage' && id_array[i] != 'type') {
				input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
			} else if (id_array[i] == 'stage') {
				input = `<select name='${id_array[i]}' id='${id_array[i]}'>
                        <option value="ideation">Ideation</option>
                        <option value="proposalInProgress">Proposal in Progress</option>
                        <option value="awaitingFunding">Awaiting Funding</option>
                        <option value="inProgress">In Progress</option>
                        <option value="completedNotSignedOff">Completed - Not Signed Off</option>
                        <option value="completedSignedOff">Completed - Signed Off</option>
                   		</select>`;
                input = input.replace(`>${text}<`, `selected>${text}<`);
			} else if (id_array[i] == 'type') {
				input = `<input list="projectTypes" name='${id_array[i]}' id='${id_array[i]}' value="${text}">
                            <datalist id="projectTypes">
                                <option value="Community">
                                <option value="Technical">
                                <option value="Business">
                            </datalist>`;
			}
			document.querySelector(`span#${id_array[i]}`).innerHTML = input;
		}
		document.querySelector(`div#saveEditProject`).innerHTML = "<button onclick='return false;'>Save</button>";
	};
	function editActivity(activityCode,cl, co, s, con) {
		document.querySelector(`a#editActivity${activityCode}`).setAttribute("onclick","return false;");
		let id_array = [];
		for (let i = 1; i <= cl; i++) { id_array.push(`client${i}`);}
		id_array.push(`principalResearcher`);
		for (let i = 1; i <= co; i++) { id_array.push(`coResearcher${i}`);}
		for (let i = 1; i <= s; i++) { id_array.push(`student${i}`);}
		for (let i = 1; i <= con; i++) { id_array.push(`contractor${i}`);}
		for (let i = 0; i < id_array.length; i++) {
			let text = document.querySelector(`fieldset#activity${activityCode} span#${id_array[i]}`).innerHTML;
			if (text == '') {text = "abc" + Math.floor(Math.random() * 100);}
			let input = "";
			input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
			document.querySelector(`fieldset#activity${activityCode} span#${id_array[i]}`).innerHTML = input;
		}
		document.querySelector(`div#saveEditActivity${activityCode}`).innerHTML = "<button onclick='return false;'>Save</button>";
	};
</script>
</head>
<body onload='displayHeader()'>
	<div class='header' id='header'></div>
	<br>
	<h1>Project : 123456</h1>
	<br>
	<fieldset>
	<legend align="right"><a id="editProject" onclick="editProject(<?= $numOfFunders; ?>);return false;" href="#">Edit</a></legend>		
  		<p>Title: <span id="title">ABC</span></p><br>
  		<p>Stage: <span id="stage">In Progress</span></p><br>
  		<p>Description: <span id="description">GHI</span></p><br>
  		<p>Type: <span id="type">Business</span></p><br>
  		<p>Manager: <span id="manager">MNO</span></p><br>
  		<p>Start Date: <span id="startDate">date1</span></p><br>
  		<p>End Date: <span id="endDate">date2</span></p><br>
  		<?php 
  		for ($i = 1; $i <= $numOfFunders; $i++) { echo "<p>Funder {$i}: <span id='funder{$i}'>funding{$i}</span></p><br>"; }
  		?>
  		<div id="saveEditProject"></div>
	</fieldset>
	<?php
	for ($j = 0; $j < $numOfActivities; $j++) {
	    $rando = random_int(100, 999);
	   $activity = "<br><h2>Activity : {$rando} </h2> <br> <fieldset id='activity{$rando}'>";
	   $activity .= "<legend align='right'><a id='editActivity{$rando}' onclick='editActivity({$rando},{$numOfClients},{$numOfCoResearchers},{$numOfStudents},{$numOfContractors});return false;' href='#'>Edit</a></legend>";
	   for ($i = 1; $i <= $numOfClients; $i++) { $activity .= "<br><p>Client {$i}: <span id='client{$i}'>ABC{$i}</span></p>"; }
	   $activity .= "<br><p id='principalResearcher'>Principal Researcher: <span id='principalResearcher'>DEF</span></p>";
	   for ($i = 1; $i <= $numOfCoResearchers; $i++) { $activity .= "<br><p>Co-Researcher {$i}: <span id='coResearcher{$i}'>GHI{$i}</span></p>"; }
	   for ($i = 1; $i <= $numOfStudents; $i++) { $activity .= "<br><p>Student {$i}: <span id='student{$i}'>JKL{$i}</span></p>"; }
	   for ($i = 1; $i <= $numOfContractors; $i++) { $activity .= "<br><p>Contractor {$i}: <span id='contractor{$i}'>MNO{$i}</span></p>"; }
	   $activity .= "<br><div id='saveEditActivity{$rando}'></div>";
	   $activity .= "<br></fieldset>";
	   echo $activity;
	}
	?>
 </body>
 </html>