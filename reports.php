<?php include 'loginchecker.php';?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
	<title>Reports</title>
	<link rel='stylesheet' href='index.css'>
	<script src='header.js'></script>
	<script src='financialReports.js'></script> 
</head>

<body onload='displayHeader()'>
	<div class='header' id='header' name='header'></div>
    <div class='queries' id='queries'>
        <h1 class='centered' id='queriesH1'>Generate Reports</h1>
        <br />
        <br /><br />
        <p class='query' id='receivedYear'><input onclick='displayByYear("fundingReceivedYear","receivedStartDate","receivedEndDate","fundingByYear")' type='button' class='queryButton' id='amtFundingYearBtn' value='Show'> Amount of funding received between <input class='dateInput' id='receivedStartDate' type='date' value='2022-03-01'> and <input type='date' class='dateInput' id='receivedEndDate' value='2023-03-01'><div class='reportGeneration' id='fundingReceivedYear'></div></p>
        <br /><br />
        <p class='query' id='projectsYear'><input onclick='displayByYear("projectsByYear","projectStartDate","projectEndDate","projectsByYear")' type='button' class='queryButton' id='projectYearBtn' value='Show'> Projects between the date <input class='dateInput' id='projectStartDate' type='date' value='2022-01-01'> and <input type='date' class='dateInput' id='projectEndDate' value='2025-01-01'><div class='reportGeneration' id='projectsByYear'></div></p>
        <br /><br />
        <p class='query' id='contractorsYear'><input onclick='displayByYear("projectsByYear","projectStartDate","projectEndDate","contractorsByYear")' type='button' class='queryButton' id='contractorsYearBtn' value='Show'> Contractors on projects between the date <input class='dateInput' id='projectStartDate' type='date' value='2022-01-01'> and <input type='date' class='dateInput' id='projectEndDate' value='2025-01-01'><div class='reportGeneration' id='contractorsByYear'></div></p>
        <br /><br />
        <p class='query' id='allStudents'><input onclick='displayAll("allStudentsQuery","allStudents")' type='button' class='queryButton' id='allStudentsQueryBtn' value='Show'> All student researchers<div class='reportGeneration' id='allStudentsQuery'></div></p>
        <br /><br />
        <p class='query' id='allResearchers'><input onclick='displayAll("allResearchersQuery","allResearchers")' type='button' class='queryButton' id='allResearchersBtn' value='Show'> All non-student researchers<div class='reportGeneration' id='allResearchersQuery'></div></p>
        <br /><br />
    </div>
</body>
</html>