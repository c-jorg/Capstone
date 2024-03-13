<?php
include 'Project.php';
$pCode = 123;

$numOfClients = 1;
$numOfCoResearchers = 1;
$numOfStudents = 1;
$numOfContractors = 1;
$numOfActivities = 1;
$newP = new Project($pCode);
count($newP->funders);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <script src='projectPage.js'></script>
    <title>Project : <?=$pCode?></title>
<script>
	function editProject(pCode, numOfFunders) {
		document.querySelector(`a#editProject`).setAttribute("onclick","return false;");
		const id_array = ['title','stage','description','type','manager','startDate','endDate'];
		for (let i = 1; i <= numOfFunders; i++) {
			id_array.push(`funder${i}`);
		}
		for (let i = 0; i < id_array.length; i++) {
			let text = document.querySelector(`span#${id_array[i]}`).innerHTML;
			if (text === '') {text = "abc" + Math.floor(Math.random() * 100);}
			let input = "";
			if (id_array[i] !== 'stage' && id_array[i] !== 'type') {
				input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
			} else if (id_array[i] === 'stage') {
				input = `<select name='${id_array[i]}' id='${id_array[i]}'>
                        <option value="ideation">Ideation</option>
                        <option value="proposalInProgress">Proposal in Progress</option>
                        <option value="awaitingFunding">Awaiting Funding</option>
                        <option value="inProgress">In Progress</option>
                        <option value="completedNotSignedOff">Completed - Not Signed Off</option>
                        <option value="completedSignedOff">Completed - Signed Off</option>
                   		</select>`;
                input = input.replace(`>${text}<`, `selected>${text}<`);
			} else if (id_array[i] === 'type') {
				input = `<input list="projectTypes" name='${id_array[i]}' id='${id_array[i]}' value="${text}">
                            <datalist id="projectTypes">
                                <option value="Community">
                                <option value="Technical">
                                <option value="Business">
                            </datalist>`;
			}
			document.querySelector(`span#${id_array[i]}`).innerHTML = input;
		}
		document.querySelector(`div#saveEditProject`).innerHTML = `<button onclick='saveEditProject(${pCode},${numOfFunders});return false;'>Save</button>`;
	};
	function saveEditProject(pCode, numOfFunders) {
            document.querySelector(`a#editProject`).setAttribute("onclick",`editProject(${pCode},${numOfFunders});return false;`);
            const id_array = ['title','description','stage','type','manager','startDate','endDate'];
            const data = [pCode];
            for (let i = 1; i <= numOfFunders; i++) { id_array.push(`funder${i}`); }
            for (let i = 0; i < id_array.length; i++) {
                if (id_array[i] === 'stage') {
                    data.push(document.querySelector(`select#${id_array[i]}`).value);
                    document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`select#${id_array[i]}`).value;
                } 
                else {
                    data.push(document.querySelector(`input#${id_array[i]}`).value);
                    document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`input#${id_array[i]}`).value;
               }
            }
            document.querySelector(`div#saveEditProject`).innerHTML = "";
            console.log("BEFORE: " + data);
            insertEditedProject(data);
	}
        function insertEditedProject(data) {
            console.log(data);
            const request = new XMLHttpRequest();
            request.onload = function(){
                let responseString = this.responseText;
                console.log(responseString);
            };
            const pField = ['project_code', 'title', 'description', 'stage', 'type', 'project_manager', 'start_date', 'end_date'];
            let path = "saveEdits.php?";
            for (let i = 0; i < data.length; i++) {
                path += pField[i] + "=" + data[i];
                if(i + 1 !== data.length) { path += "&"; }
            }
            request.open("GET",path);
            request.send();
        }
	function editActivity(activityCode,cl, co, s, con) {
		document.querySelector(`a#editActivity${activityCode}`).setAttribute("onclick","return false;");
		let id_array = ['activityTitle','activityDescription'];
		for (let i = 1; i <= cl; i++) { id_array.push(`client${i}`);}
		id_array.push(`principalResearcher`);
		for (let i = 1; i <= co; i++) { id_array.push(`coResearcher${i}`);}
		for (let i = 1; i <= s; i++) { id_array.push(`student${i}`);}
		for (let i = 1; i <= con; i++) { id_array.push(`contractor${i}`);}
		for (let i = 0; i < id_array.length; i++) {
			let text = document.querySelector(`fieldset#activity${activityCode} span#${id_array[i]}`).innerHTML;
			if (text === '') {text = "abc" + Math.floor(Math.random() * 100);}
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
	<h1>Project : 123</h1>
        <br>
	<fieldset>
	<legend align="right"><a id="editProject" onclick="editProject(<?=$pCode;?>,<?=count($newP->funders);?>);return false;" href="#">Edit</a></legend>		
  		<p>Title: <span id="title"><?=$newP->title?></span></p><br>
  		<p>Stage: <span id="stage"><?=$newP->stage?></span></p><br>
  		<p>Description: <span id="description"><?=$newP->description?></span></p><br>
                <p>Type: <span id="type"><?=$newP->type?></span></p><br>
  		<p>Manager: <span id="manager"><?=$newP->manager?></span></p><br>
  		<p>Start Date: <span id="startDate"><?=$newP->startDate?></span></p><br>
  		<p>End Date: <span id="endDate"><?=$newP->endDate?></span></p><br>
  		<?php 
            for ($i = 0; $i < count($newP->funders); $i++) { $j = $i+1; echo "<p>Funder {$j}: <span id='funder{$j}'>" . $newP->funders[$i] . "</span></p><br>";}            
  		?>
  		<div id="saveEditProject"></div>
	</fieldset>
	<?php
	for ($j = 0; $j < $numOfActivities; $j++) {
	    $rando = random_int(100, 999);
	   $activity = "<br><h2>Activity : {$rando} </h2> <br> <fieldset id='activity{$rando}'>";
	   $activity .= "<legend align='right'><a id='editActivity{$rando}' onclick='editActivity({$rando},{$numOfClients},{$numOfCoResearchers},{$numOfStudents},{$numOfContractors});return false;' href='#'>Edit</a></legend>";
	   $activity .= "<br><p id='activityTitle'>Activity Title: <span id='activityTitle'>A-Title</span></p>";
	   $activity .= "<br><p id='activityDescription'>Activity Description: <span id='activityDescription'>A-Description</span></p>";
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
