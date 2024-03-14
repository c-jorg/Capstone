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
		function addMoreField(index, fieldName) {
			const s = `<br>	<label for="${fieldName}${index}">${fieldName} ${index}:</label>
							<input type="text" id="${fieldName}${index}" name="${fieldName}${index}">
                			<span id="add${fieldName}${index+1}">
                				<a onclick="addMoreField(${index+1},'${fieldName}');return false;" href="#">+add</a>
                			</span>`;
  			document.getElementById(`add${fieldName}${index}`).innerHTML = s;
		};
		function addFunderField(num){
			const s = `<br>	<label for="funder${num}">Funder ${num}:</label>
							<input type="text" id="funder${num}" name="funder${num}" required>
							&emsp;
							<label for="fundingTotal${num}">Funding Total: $</label>
            				<input type="number" id="funding${num}" name="funding${num}" min="1" step="any" pattern="^\d+(\.)\d{2}$" required>
            				<input type="checkbox" id="yearly${num}" name="yearly${num}" value="yearly${num}">
            				<label for="yearly${num}">yearly</label>
							&emsp;
                			<span id="addFunder${num+1}">
                				<a onclick="addFunderField(${num+1});return false;" href="#">+add</a>
                			</span>
			`;
  			document.getElementById(`addFunder${num}`).innerHTML = s;
		};
		function addEntity() {
            const salutation = document.getElementById(`salutation`).value;
            const firstName = document.getElementById(`firstName`).value;
            const lastName = document.getElementById(`lastName`).value;
            const company = document.getElementById(`company`).value;
            const email = document.getElementById(`email`).value;
            const category = document.getElementById(`category`).value;
            console.log(salutation, firstName, lastName, company, email, category);
           	
           	const entries = `salutation=$salutation&
           					 first_name=$firstName&
           					 last_name=$lastName&
           					 company=$company&
           					 email=$email&
           					 category=$category`;
           	
            const request = new XMLHttpRequest();
            request.onload = function(){
                document.getElementById("addEntityReponse").innerHTML = this.responseText;
            };
            request.open("GET","insertEntity.php?" + entries);
            request.send();
        };
	</script>
	</head>
	<body onload='displayHeader()'>
  		<div class='header' id='header'></div>
		<h1>Create Project</h1>
			<fieldset id="addEntity">
				<h4>Add Entity:</h4>&emsp; <div id="addEntityReponse"></div>
				<br>
    			<label for="salutation">Salutation:</label>
                <select name="salutation" id="salutation">
                    <option value="None" selected>None</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Miss">Miss</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Dr.">Dr.</option>
                </select>
				<br><br>
				<label for="firstName">First Name:</label>
				<input type="text" id="firstName" name="firstName">
				<br><br>
				<label for="lastName">Last Name:</label>
				<input type="text" id="lastName" name="lastName">
				<br><br>
				<label for="company">Company:</label>
				<input type="text" id="company" name="company">
				<br><br>
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required>
				<br><br>
				<label for="category">Category:</label>
				<select name="category" id="category">
                    <option value="None" selected>None</option>
                    <option value="Student - Undergraduate">Student - Undergraduate</option>
                    <option value="Student - Masters">Student - Masters</option>
                    <option value="Student - PhD">Student - PhD</option>
                    <option value="Student - Other">Student - Other</option>
                </select>
                <br><br>
				<button onclick="addEntity();return false;">Add Entity</button>
			</fieldset>
		<form method="post" action="projectList.php">
			<fieldset>
				<h3>Project Details</h3>
				<br>
				<label for="projectCode">Project Code:</label>
				<input type="text" id="projectCode" name="projectCode" required>

				<br><br>
				<label for="projectTitle">Project Title:</label>
				<input type="text" id="projectTitle" name="projectTitle" required>
				&emsp;
				<label for="stage">Project Stage:</label>
                <select name="stage" id="stage">
                    <option value="Ideation">Ideation</option>
                    <option value="Proposal In Progress">Proposal in Progress</option>
                    <option value="Awaiting Funding">Awaiting Funding</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed - Not Signed Off">Completed - Not Signed Off</option>
                    <option value="Completed - Signed Off">Completed - Signed Off</option>
                </select>
				<br><br>
				<label for="projectDescription">Project Description:</label><br>
				<textarea id="projectDescription" name="projectDescription" rows="4" cols="100" required></textarea>
				<br><br>
				<label for="projectType">Project Type:</label>
				<input list="projectTypes" name="projectType" id="projectType">
                <datalist id="projectTypes">
                    <option value="Community">
                    <option value="Technical">
                    <option value="Business">
                </datalist>
                <br><br>
				<label for="projectManager">Project Manager:</label>
				<input type="text" id="projectManager" name="projectManager" required>
				<br><br>
				<div id="funders">
    				<label for="funder1">Funder 1:</label>
    				<input type="text" id="funder1" name="funder1" required>
    				&emsp;
    				<label for="fundingTotal">Funding Total: $</label>
    				<input type="number" id="funding" name="funding" min="1" step="any" pattern="^\d+(\.)\d{2}$" required>
    				<input type="checkbox" id="yearly1" name="yearly1" value="yearly1">
    				<label for="yearly1">yearly</label>
    				&emsp;
    				<span id='addFunder2'>
    					<a onclick="addFunderField(2);return false;" href="#">+add</a>
    				</span>
    			</div>
				<br>
				<label for="pStartDate">Start Date:</label>
				<input type="date" id="pStartDate" name="pStartDate" required>&emsp;
				<label for="pEndDate">End Date:</label>
				<input type="date" id="pEndDate" name="pEndDate" required>
				<br><br>
				<input type="submit" value="Create Project" style="width:100px">		
				<br><br>
			</fieldset>
		</form>
		<form  method="post" action="#">
			<fieldset>
				<h3>Activity Details</h3>
				<br>
				<label for="forProjectCode">Project Code:</label>
				<input type="text" id="forProjectCode" name="forProjectCode" required>
				&emsp;
				<label for="activityCode">Activity Code:</label>
				<input type="text" id="activityCode" name="activityCode" required>
				<br><br>

				<label for="activityTitle">Activity Title:</label>
				<input type="text" id="activityTitle" name="activityTitle" required>
				<br><br>
				<label for="activityDescription">Activity Description:</label><br>
				<textarea id="projectDescription" name="activityDescription" rows="4" cols="100"></textarea>
				<br><br>
				<label for="a1StartDate">Start Date:</label>
				<input type="date" id="a1StartDate" name="a1StartDate" required>&emsp;
				<label for="a1EndDate">End Date:</label>
				<input type="date" id="a1EndDate" name="a2EndDate" required>
				<br><br>
				<div id="clients">
    				<label for="Client1">Client 1:</label>
    				<input type="text" id="Client1" name="Client1" required>
    				<span id='addClient2'>
        				<a onclick="addMoreField(2,'Client');return false;" href="#">+add</a>
        			</span>
    			</div>
				<br>
				<label for="principalResearcher">Principal Researcher:</label>
				<input type="text" id="principalResearcher" name="principalResearcher" required>
				<br><br>
				<div id="researchers">
    				<label for="Co-Researcher1">Co-Researcher 1:</label>
    				<input type="text" id="Co-Researcher1" name="Co-Researcher1" required>
  					<span id='addCo-Researcher2'>
    					<a onclick="addMoreField(2,'Co-Researcher');return false;" href="#">+add</a>
    				</span>
    			</div>
				<br>
				<div id="students">

    				<label for="Student1">Student 1:</label>
    				<input type="text" id="Student1" name="Student1" required>
    				<span id='addStudent2'>
    					<a onclick="addMoreField(2,'Student');return false;" href="#">+add</a>

    				</span>
				</div>
				<br>
				<div id="contractors">

    				<label for="Contractor1">Contractor 1:</label>
    				<input type="text" id="Contractor1" name="Contractor1" required>
    				<span id='addContractor2'>
        				<a onclick="addMoreField(2,'Contractor');return false;" href="#">+add</a>

        			</span>
    			</div>
				<br>
				<label for="notes">Notes:</label><br>
				<textarea id="notes" name="notes" rows="8" cols="110"></textarea>
				<br><br>
				<input type="submit" value="Add Activity" style="width:100px">	
				<br><br>	
			</fieldset>
		</form>
	</body>

</html>

