<!-- Create new project Form -->
<html>
	<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <script src='header.js'></script>
    <title>Create Project</title>
	<script>
		function addFunderField(num){
			const s = `<br>	<label for="funder${num}">Funder ${num}:</label>
							<input type="text" id="funder${num}" name="funder${num}" required>
                			<span id="addFunder${num+1}">
                				<a onclick="addFunderField(${num+1});return false;" href="#">+add</a>
                			</span>
			`;
  			document.getElementById(`addFunder${num}`).innerHTML = s;
		};
		function addResearcherField(num){
			const s = `<br>	<label for="researcher${num}">Researcher ${num}:</label>
							<input type="text" id="researcher${num}" name="researcher${num}" required>
							<input type="checkbox" id="lead" name="lead" value="yesLead">
      						<label for="lead"> Lead</label>
                			<span id="addResearcher${num+1}">
                				<a onclick="addResearcherField(${num+1});return false;" href="#">+add</a>
                			</span>
			`;
  			document.getElementById(`addResearcher${num}`).innerHTML = s;
		};
		function addStudentField(num){
			const s = `<br>	<label for="student${num}">Student ${num}:</label>
							<input type="text" id="student${num}" name="student${num}" required>
                			<span id="addStudent${num+1}">
                				<a onclick="addStudentField(${num+1});return false;" href="#">+add</a>
                			</span>
			`;
  			document.getElementById(`addStudent${num}`).innerHTML = s;
		};
	</script>
	</head>
	<body onload='displayHeader()'>
  		<div class='header' id='header'></div>
		
		<h1>Create Project</h1>
		<form method="post" action="projectList.php">
			<fieldset>
				<h3>Project Details</h3>
				<label for="projectCode">Project Code:</label>
				<input type="text" id="projectCode" name="projectCode" required>
				<br><br>
				<label for="title">Title:</label>
				<input type="text" id="title" name="title" required>
				<br><br>
				<label for="stage">Project Stage:</label>
                <select name="stage" id="stage">
                    <option value="ideation">Ideation</option>
                    <option value="proposalInProgress">Proposal in Progress</option>
                    <option value="awaitingFunding">Awaiting Funding</option>
                    <option value="inProgress">In Progress</option>
                    <option value="completedNotSignedOff">Completed - Not Signed Off</option>
                    <option value="completedSignedOff">Completed - Signed Off</option>
                </select>
				<br><br>
				<label for="description">Description:</label><br>
				<textarea id="description" name="description" rows="4" cols="55" required></textarea>
				<br><br>
				<label for="projectType">Project Type:</label>
                <select name="projectType" id="projectType">
                    <option value="community">Community</option>
                    <option value="technical">Technical</option>
                    <option value="business">Business</option>
                    <option value="other">Other...</option>
                </select>
				<br><br>
				<div id="funders">
    				<label for="funder1">Funder 1:</label>
    				<input type="text" id="funder1" name="funder1" required>
    				<span id='addFunder2'>
    					<a onclick="addFunderField(2);return false;" href="#">+add</a>
    				</span>
    			</div>
				<br>
				<label for="fundingTotal">Funding Total: $</label>
				<input type="number" id="funder" name="funder" min="1" step="any" pattern="^\d+(\.)\d{2}$" required>
				<input type="radio" id="yearly" name="frequency" value="yearly">
				<label for="yearly">yearly</label>
				<input type="radio" id="monthly" name="frequency" value="monthly">
				<label for="monthly">monthly</label>
				<br><br>
				<label for="startDate">Start Date:</label>
				<input type="date" id="startDate" name="startDate" required>&emsp;
				<label for="endDate">End Date:</label>
				<input type="date" id="endDate" name="endDate" required>
				<br><br>
				<label for="client">Client:</label>
				<input type="text" id="client" name="client" required>
				<br><br>
				<div id="researchers">
    				<label for="reasercher1">Researcher 1:</label>
    				<input type="text" id="reasercher1" name="researcher1" required>
    				<input type="checkbox" id="lead" name="lead" value="yesLead">
      				<label for="lead"> Lead</label>
  					<span id='addResearcher2'>
    					<a onclick="addResearcherField(2);return false;" href="#">+add</a>
    				</span>
    			</div>
				<br><br>
				<div id="students">
    				<label for="student1">Student 1:</label>
    				<input type="text" id="student1" name="student1" required>
    				<span id='addStudent2'>
    					<a onclick="addStudentField(2);return false;" href="#">+add</a>
    				</span>
				</div>
				<br><br>
				<label for="contractor">Contractor:</label>
				<input type="text" id="contractor" name="contractor" required>
				<br><br>
				<label for="notes">Notes:</label><br>
				<textarea id="notes" name="notes" rows="8" cols="55"></textarea>
				<br><br>
				<input type="submit" value="Create Project">
					
			</fieldset>
		</form>
	</body>
</html>