/**
 *  projectPosting.js
 *  associated with projectPosting.php
 */
function addMoreField(index, fieldName) {
	const s = `<br>	<label for="${fieldName}${index}">${fieldName} ${index}:</label>
				<input list="entities" name="${fieldName}${index}}" id="${fieldName}${index}" style="width:200px;">
            	<datalist id="entities"></datalist>
                <span id="add${fieldName}${index+1}">
                	<a onclick="removeMoreField(${index},'${fieldName}');return false;" href='#'>-remove</a>;       
    				&emsp;
                	<a onclick="addMoreField(${index+1},'${fieldName}');return false;" id="addLink" href="#">+add</a>
                </span>`;
	document.getElementById(`add${fieldName}${index}`).innerHTML = s;
};
function removeMoreField(index, fieldName) {
	let s = "";
	if(index === 2) {
		s = `<a onclick="addMoreField(${index},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;
	} else {
		s = `<a onclick="removeMoreField(${index-1},'${fieldName}');return false;" href='#'>-remove</a>
    		&emsp;
			<a onclick="addMoreField(${index},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;
	}
	document.getElementById(`add${fieldName}${index}`).innerHTML = s;
};
function addFunderField(num) {
	const s = `<br>	<label for="funder${num}">Funder ${num}:</label>
				<input list="entities" name="funder${num}" id="funder${num}" style="width:200px;">
            	<datalist id="entities"></datalist>
				&emsp;
				<label for="amount${num}">Amount: $</label>
				<input type="number" id="amount${num}" name="amount${num}" min="1" step="any">
				&emsp;
				<label for="dateReceived${num}">Date Received:</label>
				<input type="date" id="dateReceived${num}" name="dateReceived${num}">
				&emsp;
				<input type="checkbox" id="yearly${num}" name="yearly${num}" value="yearly">
				<label for="yearly${num}">yearly</label>
				&emsp;
    			<span id="addFunder${num+1}">
    				<a onclick='removeFunderField(${num});return false;' href='#'>-remove</a>
    				&emsp;
    				<a onclick="addFunderField(${num+1});return false;" id="addLink"  href="#">+add</a>
    			</span>`;
  	document.getElementById(`addFunder${num}`).innerHTML = s;
};
function removeFunderField(num) {
	let s = "";
	if(num === 2) {
		s = `<a onclick='addFunderField(${num});return false;' id="addLink" href='#'>+add</a>`;
	} else {
		s = `<a onclick='removeFunderField(${num-1});return false;' href='#'>-remove</a>
    		&emsp;
			<a onclick='addFunderField(${num});return false;' id="addLink" href='#'>+add</a>`;
	}
	document.getElementById(`addFunder${num}`).innerHTML = s;
};
function addContractorField(num) {
	const s = `<br>	<label for="Contractor${num}">Contractor ${num}:</label>
				<input list="entities" name="Contractor${num}" id="Contractor${num}" style="width:200px;">
        		<datalist id="entities"></datalist>
				&emsp;
				<label for="payment${num}">Payment: $</label>
				<input type="number" id="payment${num}" name="payment${num}" min="1" step="any">
        		&emsp;
        		<label for="payDate${num}">Pay Date:</label>
				<input type="date" id="payDate${num}" name="payDate${num}">
    			<span id='addContractor${num+1}'>
    				<a onclick="removeContractorField(${num});return false;" href='#'>-remove</a>
    				&emsp;
    				<a onclick="addContractorField(${num+1});return false;" id="addLink" href="#">+add</a>
    			</span>`;
  	document.getElementById(`addContractor${num}`).innerHTML = s;
};
function removeContractorField(num) {
	let s = "";
	if(num == 2) {
		s = `<a onclick='addContractorField(${num});return false;' id="addLink" href='#'>+add</a>`;
	} else {
		s = `<a onclick='removeContractorField(${num-1});return false;' href='#'>-remove</a>
    		&emsp;
			<a onclick='addContractorField(${num});return false;' id="addLink" href='#'>+add</a>`;
	}
	document.getElementById(`addContractor${num}`).innerHTML = s;
};
function addEntity() {
	const email = document.getElementById(`email`).value;
	document.getElementById("isEmailValid").innerHTML = "";
	if(isEmailValid(email)) {
        const salutation = document.getElementById(`salutation`).value;
        const firstName = document.getElementById(`firstName`).value;
        const lastName = document.getElementById(`lastName`).value;
        const company = document.getElementById(`company`).value;
        const category = document.getElementById(`category`).value;
        console.log("addEntity:\t",salutation, firstName, lastName, company, email, category);
       	
       	document.getElementById(`salutation`).value = "None";
        document.getElementById(`firstName`).value = "";
        document.getElementById(`lastName`).value = "";
        document.getElementById(`company`).value = "";
        document.getElementById(`email`).value = "";
        document.getElementById(`category`).value  = "None" ;
 
       	
       	const entries = `salutation=$salutation&
       					 first_name=$firstName&
       					 last_name=$lastName&
       					 company=$company&
       					 email=$email&
       					 category=$category`;
               	
//                 const request = new XMLHttpRequest();
//                 request.onload = function(){
//                     document.getElementById("addEntityReponse").innerHTML = this.responseText;
//                 };
//                 request.open("GET","insertEntity.php?" + entries);
//                 request.send();
	} else {
		 document.getElementById("isEmailValid").innerHTML = "Must provide a valid email!";
	}
};
function isEmailValid(email) {        	
	return email.toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
};
function createProject() {
	const code =  document.getElementById(`projectCode`).value;
	document.getElementById("isProjectCodeEmpty").innerHTML = "";
	if(code) {
	    const title = document.getElementById(`projectTitle`).value;
	    const stage = document.getElementById(`stage`).value;
	    const description = document.getElementById(`projectDescription`).value;
	    const type = document.getElementById(`type`).value;
	    const manager = document.getElementById(`projectManager`).value;
	    
	    let i = 1;
	    let funder = [];
	    let amount = [];
	    let dateReceived = [];
	    let frequency = [];
	    while (document.getElementById(`funder${i}`) != null) {
		    funder.push(document.getElementById(`funder${i}`).value);
		    amount.push(document.getElementById(`amount${i}`).value);
		    dateReceived.push(document.getElementById(`dateReceived${i}`).value);
		    frequency.push(document.getElementById(`yearly${i}`).checked ? "yearly" : "lumpsum");
		    if (i > 1) { removeFunderField(i); }
		    i++;
		}
		const startDate = document.getElementById(`pStartDate`).value;
	    const endDate = document.getElementById(`pEndDate`).value;
		
	    console.log(code, title, stage, description, type, manager, funder, amount, frequency, startDate, endDate);		
		
		document.getElementById(`projectCode`).value = "";
	    document.getElementById(`projectTitle`).value = "";
	    document.getElementById(`stage`).value = "";
	    document.getElementById(`projectDescription`).value = "";
	    document.getElementById(`type`).value = "";
	    document.getElementById(`projectManager`).value  = "";
	    document.getElementById(`funder1`).value = "";
	    document.getElementById(`amount1`).value = "";
	    document.getElementById(`dateReceived1`).value = "";
	    document.getElementById(`yearly1`).checked = false;
	    document.getElementById(`pStartDate`).value = "";
	    document.getElementById(`pEndDate`).value = "";
	    
       	let project = `project_code=$code&
				 		 title=$title&
				 		 description=$description&
						 stage=$stage&
						 type=$type&
						 start_date=$startDate&
						 end_date=$endDate`;
		// Need to find how to access entities list
               	
//                 const request = new XMLHttpRequest();
//                 request.onload = function(){
//                     document.getElementById("addEntityReponse").innerHTML = this.responseText;
//                 };
//                 request.open("GET","insertEntity.php?" + entries);
//                 request.send();
	    
	} else {
		document.getElementById("isProjectCodeEmpty").innerHTML = "Must provide a project code!";
	}
};
function createActivity() {
	const pCode = document.getElementById(`a1ProjectCode`).value;
	const aCode = document.getElementById(`activity1Code`).value;
	document.getElementById("isA1ProjectCodeEmpty").innerHTML = "";
	document.getElementById("isA1ActivityCodeEmpty").innerHTML = "";
	if(!pCode) {
		document.getElementById("isA1ProjectCodeEmpty").innerHTML = "Must provide a project code!";
		return;
	} else if(!aCode) {
		document.getElementById("isA1ActivityCodeEmpty").innerHTML = "Must provide an activity code!";
		return;
	} else {
	    const title = document.getElementById(`activityTitle`).value;
	    const description = document.getElementById(`activityDescription`).value;
	    const startDate = document.getElementById(`a1StartDate`).value;
	    const endDate = document.getElementById(`a1EndDate`).value;
	    const principalResearcher = document.getElementById(`principalResearcher`).value;
	    
	    let i = 1;
	    let client = [];
	    while (document.getElementById(`Client${i}`) != null) {
			console.log("HERE 1");
			client.push(document.getElementById(`Client${i}`).value);
			if(i > 1) { removeMoreField(i,'Client'); }
			i++;
		}
		let j = 1;
	    let researcher = [];
	    while (document.getElementById(`Researcher${j}`) != null) {
			console.log("HERE 2");
			researcher.push(document.getElementById(`Researcher${j}`).value);
			if(j > 1) { removeMoreField(j,'Researcher'); }
			j++;
		}
		let k = 1;
	    let contractor = [];
	    let payment = [];
	    let payDate = [];
	   	while (document.getElementById(`Contractor${k}`) != null) {
			console.log("HERE 3");
			contractor.push(document.getElementById(`Contractor${k}`).value);
			payment.push(document.getElementById(`payment${k}`).value);
			payDate.push(document.getElementById(`payDate${k}`).value);		
			if (k > 1) { removeContractorField(k); }
			k++;
		}

		
	    console.log(pCode, aCode, title, startDate, endDate, client, principalResearcher, researcher, contractor, payment, payDate);		
		
		
		document.getElementById(`a1ProjectCode`).value = "";
	    document.getElementById(`activity1Code`).value = "";
	    document.getElementById(`activityTitle`).value = "";
	    document.getElementById(`activityDescription`).value = "";
	    document.getElementById(`a1StartDate`).value = "";
	    document.getElementById(`a1EndDate`).value  = "";
	    document.getElementById(`Client1`).value = "";
	    document.getElementById(`principalResearcher`).value = "";
	    document.getElementById(`Researcher1`).value = "";
	    document.getElementById(`Contractor1`).value = "";
	    document.getElementById(`payment1`).value = "";
	    document.getElementById(`payDate1`).value = "";
	    
       	let activity = `project_code=$pcode&
       					activity_code=$acode&
				 		 title=$title&
				 		 description=$description&
						 start_date=$startDate&
						 end_date=$endDate&
						 `;
//<<<<<<<<<<<<<<<<<<<<<<<<CONTINUE
		// Need to find how to access entities list
               	
//                 const request = new XMLHttpRequest();
//                 request.onload = function(){
//                     document.getElementById("addEntityReponse").innerHTML = this.responseText;
//                 };
//                 request.open("GET","insertEntity.php?" + entries);
//                 request.send();
	}
};