<!-- Create new project Form -->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="index.css">
        <script src='header.js'></script>
        <script src='projectPosting.js'></script>
        <?php include './entityLookUp.php'; ?>
        <title>Create Project</title>
        <script></script>
        <style>
            .statusColor{
                vertical-align: middle;
                min-width: 50px;
                padding: 0.5rem;
                border: 1px solid black;
                display: inline-block;    
            }
        </style>
    </head>
    <body onload='displayHeader()'>
        <div class='header' id='header'></div>
        <br>
        <div class="createBTNs">
            <button onclick="toggleAddEnt()" id="addEntBTN">Add Entity</button>
            <button onclick="toggleCrPr()" id="addProjBTN">Create Project</button>
            <button onclick="toggleSubPr()" id="addSubProjBTN">Create Subproject</button>
        </div>
        <br><br>
        <div id="addEnt" class="addEnt">
        <h1>Add Entity</h1>
        <fieldset id="addEntity">
            <h4>Entity Details</h4>
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
            <input type="email" id="email" name="email" required> <span id="isEmailValid" style="color:red;"></span>
            <br><br>
            <label for="category">Student designation:</label>
            <select name="category" id="category">
                <option value="None" selected>None</option>
                <option value="Student - Undergraduate">Student - Undergraduate</option>
                <option value="Student - Masters">Student - Masters</option>
                <option value="Student - PhD">Student - PhD</option>
                <option value="Student - Other">Student - Other</option>
            </select>
            <br><br>
            <button onclick="addEntity();return false;" id="addEntityBTN" style="width:200px">Add Entity</button>&ensp;<span id="addEntityReponse" style="color:red;"></span>
        </fieldset>
       </div>
        <div id="crProj" class="crProj">
        <h1>Create Project</h1>
        <fieldset>
            <h3>Project Details</h3>
            <br>
            <label for="projectCode">Project Code:</label>
            <input type="text" id="projectCode" name="projectCode" required> <span id="isProjectCodeEmpty" style="color:red;"></span>
            <br><br>
            <label for="projectTitle">Project Title:</label>
            <input type="text" id="projectTitle" name="projectTitle">
            <br><br>
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
            <span id="currentStatus">Current Status:</span>
                <input type="radio" id="red" name="currentStatus" value="Red" checked><label class="statusColor" for="red" style="background-color: red;"> </label> 
                <input type="radio" id="yellow" name="currentStatus" value="Yellow"><label class="statusColor" for="yellow" style="background-color: yellow;"> </label> 
                <input type="radio" id="green" name="currentStatus" value="Green"><label class="statusColor" for="green" style="background-color: green;"> </label> 
            <br><br>
            <label for="projectDescription">Project Description:</label><br>
            <textarea id="projectDescription" name="projectDescription" rows="4" cols="70"></textarea>
            <br><br>
            <label for="type">Project Type:</label>
            <input list="types" name="type" id="type">
            <datalist id="types">
                <option value="Community">
                <option value="Technical">
                <option value="Business">
            </datalist>
            <br><br>
            <label for="projectManager">Project Manager:</label>
            <input list="entities" name="projectManager" id="projectManager" style="width:300px;">
            <datalist id="entities"></datalist>
            <br><br>
            <label for="pStartDate">Start Date:</label>
            <input type="date" id="pStartDate" name="pStartDate">&ensp;
            <label for="pEndDate">End Date:</label>
            <input type="date" id="pEndDate" name="pEndDate">
            <br><br>
            <div id="funders">
                <label for="funder1">Funder 1:</label>
                <input list="entities" name="funder1" id="funder1" style="width:300px;">
                <datalist id="entities"></datalist>
                &ensp;
                <label for="amount1">Amount: $</label>
                <input type="number" id="amount1" name="amount1" min="1" step="any" style="width:100px;">
                &ensp;
                <label for="dateReceived1">Date Received:</label>
                <input type="date" id="dateReceived1" name="dateReceived1">
                &ensp;
                <label for="funder_end_date1">End Date:</label>
                <input type="date" id="funder_end_date1" name="funder_end_date1">
                &ensp;
                <span id='addFunder2'>
                    <a onclick="addFunderField(2);return false;" id="addLink" href="#">+add</a>
                </span>
            </div>
            <br>
            <div id="clients">
                <label for="Client1">Client 1:</label>
                <input list="entities" name="Client1" id="Client1" style="width:300px;">
                <datalist id="entities"></datalist>
                &ensp;
                <span id='addClient2'>
                    <a onclick="addMoreField(2, 'Client');return false;" id="addLink" href="#">+add</a>
                </span>
            </div>
            <br><br>
            <button  onclick="createProject()" style="width:200px">Create Project</button>&ensp;<span id="projectCreated" style="color:red;"></span>		
        </fieldset>
         </div>
        <div id="crSubproj" class="crSubproj">
        <h1>Create Subproject</h1>
        <fieldset>
            <h3>Subproject Details</h3>
            <br>
            <label for="a1ProjectCode">Project Code:</label>
            <input type="text" id="a1ProjectCode" name="a1ProjectCode"> <span id="isA1ProjectCodeEmpty" style="color:red;"></span>
            <br><br>
            <label for="activity1Code">Subproject Code:</label>
            <input type="text" id="activity1Code" name="activity1Code"> <span id="isA1ActivityCodeEmpty" style="color:red;"></span>
            <br><br>
            <label for="activityTitle">Subproject Title:</label>
            <input type="text" id="activityTitle" name="activityTitle">
            <br><br>
            <label for="activityDescription">Subproject Description:</label><br>
            <textarea id="activityDescription" name="activityDescription" rows="4" cols="70"></textarea>
            <br><br>
            <label for="a1StartDate">Start Date:</label>
            <input type="date" id="a1StartDate" name="a1StartDate" required>
            &ensp;
            <label for="a1EndDate">End Date:</label>
            <input type="date" id="a1EndDate" name="a2EndDate" required>            
            <br><br>
            <label for="principalResearcher">Principal Researcher:</label>
            <input list="entities" name="principalResearcher" id="principalResearcher" style="width:300px;">
            <datalist id="entities"></datalist>
            &ensp;
            <br><br>
            <div id="researchers">
                <label for="Researcher1">Researcher 1:</label>
                <input list="entities" name="Researcher1" id="Researcher1" style="width:300px;">
                <datalist id="entities"></datalist>
                &ensp;
                <span id='addResearcher2'>
                    <a onclick="addMoreField(2, 'Researcher');return false;" id="addLink" href="#">+add</a>
                </span>
            </div>
            <br>
            <div id="contractors">
                <label for="Contractor1">Contractor 1:</label>
                <input list="entities" name="Contractor1" id="Contractor1" style="width:300px;">
                <datalist id="entities"></datalist>
                &ensp;
                <label for="payment1">Payment: $</label>
                <input type="number" id="payment1" name="payment1" min="1" step="any">
                &ensp;
                <label for="payDate1">Pay Date:</label>
                <input type="date" id="payDate1" name="payDate1">
                &ensp;
                <span id='addContractor2'>
                    <a onclick="addContractorField(2);return false;" id="addLink" href="#">+add</a>
                </span>
            </div>
            <br>
            <label for="notes">Notes:</label><br>
            <textarea id="notes" name="notes" rows="8" cols="70"></textarea>
            <br><br>
            <button onclick="createActivity()" style="width:200px">Create Subproject</button>&ensp;<span id="activityCreated" style="color:red;"></span>			
        </fieldset>
        </div>
    </body>
</html>
