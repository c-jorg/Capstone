/**
 *  projectPosting.js
 *  associated with projectPosting.php
 */
var numOfFunders = 1;
var numOfClients = 1;
var numOfResearchers = 1;
var numOfContractors = 1;
function addMoreField(index, fieldName) {
    switch (fieldName) {
        case 'Client':
            numOfClients++;
            break;
        case 'Researcher':
            numOfResearchers++;
            break;
    }
    const s = `<br>	<label for="${fieldName}${index}">${fieldName} ${index}:</label>
                    <input list="entities" name="${fieldName}${index}" id="${fieldName}${index}" style="width:300px;">
                    <datalist id="entities"></datalist>
                    &ensp;
                    <span id="add${fieldName}${index + 1}">
                        <a onclick="removeMoreField(${index},'${fieldName}');return false;" href='#'>-remove</a>
                        &ensp;
                        <a onclick="addMoreField(${index + 1},'${fieldName}');return false;" id="addLink" href="#">+add</a>
                    </span>`;
    document.getElementById(`add${fieldName}${index}`).innerHTML = s;
}
function removeMoreField(index, fieldName) {
    switch (fieldName) {
        case 'Client':
            numOfClients--;
            break;
        case 'Researcher':
            numOfResearchers--;
            break;
    }
    let s = "";
    if (index === 2) {
        s = `<a onclick="addMoreField(${index},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;
    } else {
        s = `<a onclick="removeMoreField(${index - 1},'${fieldName}');return false;" href='#'>-remove</a>
    		&ensp;
		<a onclick="addMoreField(${index},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;
    }
    document.getElementById(`add${fieldName}${index}`).innerHTML = s;
}
function addFunderField(num) {
    const s = `<br>	<label for="funder${num}">Funder ${num}:</label>
                <input list="entities" name="funder${num}" id="funder${num}" style="width:300px;">
            	<datalist id="entities"></datalist>
                &ensp;
                <label for="amount${num}">Amount: $</label>
                <input type="number" id="amount${num}" name="amount${num}" min="1" step="any" style="width:100px;">
                &ensp;
                <label for="dateReceived${num}">Date Received:</label>
                <input type="date" id="dateReceived${num}" name="dateReceived${num}">
                &ensp;
                <label for="funder_end_date${num}">End Date:</label>
                <input type="date" id="funder_end_date${num}" name="funder_end_date${num}">
                &ensp;
                <span id="addFunder${num + 1}">
                        <a onclick='removeFunderField(${num});return false;' href='#'>-remove</a>
                        &ensp;
                        <a onclick="addFunderField(${num + 1});return false;" id="addLink"  href="#">+add</a>
                </span>`;
    numOfFunders++;
    document.getElementById(`addFunder${num}`).innerHTML = s;
}
function removeFunderField(num) {
    let s = "";
    if (num === 2) {
        s = `<a onclick='addFunderField(${num});return false;' id="addLink" href='#'>+add</a>`;
    } else {
        s = `<a onclick='removeFunderField(${num - 1});return false;' href='#'>-remove</a>
    		&ensp;
			<a onclick='addFunderField(${num});return false;' id="addLink" href='#'>+add</a>`;
    }
    numOfFunders--;
    document.getElementById(`addFunder${num}`).innerHTML = s;
}
function addContractorField(num) {
    const s = `<br>	<label for="Contractor${num}">Contractor ${num}:</label>
				<input list="entities" name="Contractor${num}" id="Contractor${num}" style="width:300px;">
        		<datalist id="entities"></datalist>
				&ensp;
				<label for="payment${num}">Payment: $</label>
				<input type="number" id="payment${num}" name="payment${num}" min="1" step="any">
        		&ensp;
        		<label for="payDate${num}">Pay Date:</label>
				<input type="date" id="payDate${num}" name="payDate${num}">
                        &ensp;
    			<span id='addContractor${num + 1}'>
    				<a onclick="removeContractorField(${num});return false;" href='#'>-remove</a>
    				&ensp;
    				<a onclick="addContractorField(${num + 1});return false;" id="addLink" href="#">+add</a>
    			</span>`;
    numOfContractors++;
    document.getElementById(`addContractor${num}`).innerHTML = s;
}
function removeContractorField(num) {
    let s = "";
    if (num === 2) {
        s = `<a onclick='addContractorField(${num});return false;' id="addLink" href='#'>+add</a>`;
    } else {
        s = `<a onclick='removeContractorField(${num - 1});return false;' href='#'>-remove</a>
    		&ensp;
			<a onclick='addContractorField(${num});return false;' id="addLink" href='#'>+add</a>`;
    }
    numOfContractors--;
    document.getElementById(`addContractor${num}`).innerHTML = s;
}
function addEntity() {
    const email = document.getElementById(`email`).value;
    document.getElementById("isEmailValid").innerHTML = "";
    if (isEmailValid(email)) {
        const salutation = document.getElementById(`salutation`).value;
        const firstName = document.getElementById(`firstName`).value;
        const lastName = document.getElementById(`lastName`).value;
        const company = document.getElementById(`company`).value;
        const category = document.getElementById(`category`).value;

        console.log("addEntity:\t", salutation, firstName, lastName, company, email, category);

        document.getElementById(`salutation`).value = "None";
        document.getElementById(`firstName`).value = "";
        document.getElementById(`lastName`).value = "";
        document.getElementById(`company`).value = "";
        document.getElementById(`email`).value = "";
        document.getElementById(`category`).value = "None";


        const entries = `salutation='${salutation}'&`
                + `first_name='${firstName}'&`
                + `last_name='${lastName}'&`
                + `company='${company}'&`
                + `email='${email}'&`
                + `category='${category}'`;
        const request = new XMLHttpRequest();
        request.onload = function () {
            document.getElementById("addEntityReponse").innerHTML = this.responseText;
            console.log(this.responseText);
        };
        request.open("GET", "insertEntity.php?" + entries);
        request.send();
    } else {
        document.getElementById("isEmailValid").innerHTML = "Must provide a valid email!";
    }
}
function isEmailValid(email) {
    return email.toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
}
function createProject() {
    const code = document.getElementById(`projectCode`).value;
    document.getElementById("isProjectCodeEmpty").innerHTML = "";
    if (code) {
        const title = document.getElementById(`projectTitle`).value;
        const stage = document.getElementById(`stage`).value;
        const description = document.getElementById(`projectDescription`).value;
        const type = document.getElementById(`type`).value;
        
        let managerId = "";
        if (document.getElementById(`projectManager`).value) {
            managerId = getEntityId(document.getElementById(`projectManager`).value);
        }
        
        const startDate = document.getElementById(`pStartDate`).value;
        const endDate = document.getElementById(`pEndDate`).value;
        let funderId = [];
        let amount = [];
        let dateReceived = [];
        let funder_end_date = [];
        for (let i = 1; i <= numOfFunders; i++) {
            if (document.getElementById(`funder${i}`).value !== "") {
                funderId.push(getEntityId(document.getElementById(`funder${i}`).value));
                amount.push(document.getElementById(`amount${i}`).value);
                dateReceived.push(document.getElementById(`dateReceived${i}`).value);
                funder_end_date.push(document.getElementById(`funder_end_date${i}`).value);
                if (i > 1) {
                    removeFunderField(i);
                } else {
                    document.getElementById(`funder${i}`).value = "";
                    document.getElementById(`amount${i}`).value = "";
                    document.getElementById(`dateReceived${i}`).value = "";
                    document.getElementById(`funder_end_date${i}`).value = "";
                }
            }
        }
        let clientId = [];
        for (let i = 1; i <= numOfClients; i++) {
            if (document.getElementById(`Client${i}`).value) {
                clientId.push(getEntityId(document.getElementById(`Client${i}`).value));
                if (i > 1) {
                    removeMoreField(i, 'Client');
                } else {
                    document.getElementById(`Client${i}`).value = "";
                }
            }
        }

        //console.log(code, title, stage, description, type, manager, funder, amount, funder_end_date, startDate, endDate);		

        document.getElementById(`projectCode`).value = "";
        document.getElementById(`projectTitle`).value = "";
        document.getElementById(`stage`).value = "Ideation";
        document.getElementById(`projectDescription`).value = "";
        document.getElementById(`type`).value = "";
        document.getElementById(`projectManager`).value = "";
        document.getElementById(`pStartDate`).value = "";
        document.getElementById(`pEndDate`).value = "";

        let project = `project_code='${code}'`
                + `&title='${title}'`
                + `&description='${description}'`
                + `&stage='${stage}'`
                + `&type='${type}'`
                + `&start_date='${startDate}'`
                + `&end_date='${endDate}'`;
        if (managerId) { project += `&project_manager='${managerId}'`; }
        project += `&numOfFunders='${funderId.length}'`;
        for (let i = 1; i <= funderId.length; i++) {
            project += `&funder${i}='${funderId[i-1]}'`
                    + `&funding_amt${i}='${amount[i-1]}'`
                    + `&date_given${i}='${dateReceived[i-1]}'`
                    + `&funder_end_date${i}='${funder_end_date[i-1]}'`;
        }
        project += `&numOfClients='${clientId.length}'`;
        for (let i = 1; i <= clientId.length; i++) {
            project += `&client${i}='${clientId[i-1]}'`;
        }
        console.log(project);
        const request = new XMLHttpRequest();
        request.onload = function () {
            document.getElementById("projectCreated").innerHTML = this.responseText;
            console.log(this.responseText);
        };
       request.open("GET", "createProject.php?" + project);
       request.send();

    } else {
        document.getElementById("isProjectCodeEmpty").innerHTML = "Must provide a project code!";
    }
}
function getEntityId(entity) {
    const id = entity.split("|");
    return parseInt(id[0].trim());
}
function createActivity() {
    const pCode = document.getElementById(`a1ProjectCode`).value;
    const aCode = document.getElementById(`activity1Code`).value;
    document.getElementById("isA1ProjectCodeEmpty").innerHTML = "";
    document.getElementById("isA1ActivityCodeEmpty").innerHTML = "";
    if (!pCode) {
        document.getElementById("isA1ProjectCodeEmpty").innerHTML = "Must provide a project code!";
        return;
    } else if (!aCode) {
        document.getElementById("isA1ActivityCodeEmpty").innerHTML = "Must provide an activity code!";
        return;
    } else {
        const title = document.getElementById(`activityTitle`).value;
        const description = document.getElementById(`activityDescription`).value;
        const startDate = document.getElementById(`a1StartDate`).value;
        const endDate = document.getElementById(`a1EndDate`).value;
        const principalResearcher = document.getElementById(`principalResearcher`).value;
        let pResearcherId = "";
        if (document.getElementById(`principalResearcher`).value) {
            pResearcherId = getEntityId(document.getElementById(`principalResearcher`).value);
            document.getElementById(`principalResearcher`).value = "";
        }     
        let researcherId = [];
        for (let i = 1; i <= numOfResearchers; i++) {
            if (document.getElementById(`Researcher${i}`).value) {
                researcherId.push(getEntityId(document.getElementById(`Researcher${i}`).value));
                if (i > 1) {
                    removeMoreField(i, 'Researcher');
                } else {
                    document.getElementById(`Researcher${i}`).value = "";
                }
            }
        }
        
        let contractorId = [];
        let payment = [];
        let payDate = [];
        for (let i = 1; i <= numOfContractors; i++) {
            if (document.getElementById(`Contractor${i}`).value !== "") {
                contractorId.push(getEntityId(document.getElementById(`Contractor${i}`).value));
                payment.push(document.getElementById(`payment${i}`).value);
                payDate.push(document.getElementById(`payDate${i}`).value);
                if (i > 1) {
                    removeContractorField(i);
                } else {
                    document.getElementById(`Contractor${i}`).value = "";
                    document.getElementById(`payment${i}`).value = "";
                    document.getElementById(`payDate${i}`).value = "";
                }
            }
        }
        const notes = document.getElementById(`notes`).value;

        //console.log(pCode, aCode, title,description, startDate, endDate, pResearcherId, researcherId, contractorId, payment, payDate);


        document.getElementById(`a1ProjectCode`).value = "";
        document.getElementById(`activity1Code`).value = "";
        document.getElementById(`activityTitle`).value = "";
        document.getElementById(`activityDescription`).value = "";
        document.getElementById(`a1StartDate`).value = "";
        document.getElementById(`a1EndDate`).value = "";
        document.getElementById(`notes`).value = "";
        
        let activity = `project_code='${pCode}'`
                       + `&activity_code='${aCode}'`
                       + `&title='${title}'`
                       + `&description='${description}'`
                       + `&start_date='${startDate}'`
                       + `&end_date='${endDate}'`
                       + `&notes='${notes}'`;
        
        if (pResearcherId) { activity += `&principal_researcher='${pResearcherId}'`; }
        activity += `&numOfResearchers='${researcherId.length}'`;
        for (let i = 1; i <= researcherId.length; i++) {
            activity += `&researcher${i}='${researcherId[i-1]}'`;
        }
        activity += `&numOfContractors='${contractorId.length}'`;
        for (let i = 1; i <= contractorId.length; i++) {
            activity += `&contractor${i}='${contractorId[i-1]}'`
                    + `&payment${i}='${payment[i-1]}'`
                    + `&date_payed${i}='${payDate[i-1]}'`;
        }
        
        console.log(activity);
        const request = new XMLHttpRequest();
        request.onload = function () {
            document.getElementById("activityCreated").innerHTML = this.responseText;
            console.log(this.responseText);
        };
       request.open("GET", "createActivity.php?" + activity);
       request.send();
    }
}
function toggleAddEnt() {
	var bt1 = document.getElementById("addEnt");
	var bt2 = document.getElementById("crProj");
	var bt3 = document.getElementById("crSubproj");

	bt1.style.display = "block";
	bt2.style.display = "none";
	bt3.style.display = "none";
}

function toggleCrPr() {
	var bt1 = document.getElementById("addEnt");
	var bt2 = document.getElementById("crProj");
	var bt3 = document.getElementById("crSubproj");

	bt1.style.display = "none";
	bt2.style.display = "block";
	bt3.style.display = "none";
}

function toggleSubPr() {
	var bt1 = document.getElementById("addEnt");
	var bt2 = document.getElementById("crProj");
	var bt3 = document.getElementById("crSubproj");

	bt1.style.display = "none";
	bt2.style.display = "none";
	bt3.style.display = "block";
}
