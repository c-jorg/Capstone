//<<<<<<<<<<jQuery
$(document).ready(() => {
    $("a#addLink").click(() => {
        loadEntities();
    });
    $(".editLink").click(() => {
        loadEntities();
    });
});
function loadEntities() {
    console.log("Loading entities...");
    $("datalist#entities").load('getEntities.php', (response, status) => {
        if (status === "success") {
            let s = "";
            const entities = response.split("+");
            for (let i = 0; i < entities.length; i++) {
                s += "<option value='" + entities[i] + "'>";
            }
            document.querySelector("datalist#entities").innerHTML = s;
        }
    });
}
//<<<<<<<<<<
var numOfFunders = 0;
var numOfClients = 0;
var numOfActivities = 0;
var numOfResearchers = [];
var numOfContractors = [];
const funderTemplate = `<p id='addFunder~'>`
        + `<span class='tag'>~: </span><span id='funder~'><input list="entities" name="funder~" id="funder~" style="width:300px;">
                <datalist id="entities"></datalist></span>&ensp;`
        + `<strong>Amount:</strong> $<span id='funding_amt~'><input type="number" id="funding_amt~" name="funding_amt~" min="1" step="any" style="width:100px"></span>&ensp;`
        + `<strong>Date Received:</strong> <span id='date_given~'><input type="date" id="date_given~" name="date_given~"></span>&ensp;`
        + `<strong>End Date:</strong> <span id='funder_end_date~'><input type="date" id="funder_end_date~" name="funder_end_date~"></span>&ensp;`
        + `<a class='removeLink' id='removeFunderLink' onclick='removeProjectField(~,"Funder");return false;' href='#'>-remove</a>`
        + `</p>`;
const clientTemplate = `<p id='addClient~'>`
        + `<span class='tag'>~: </span><span id='Client~'>`
        + `<input list="entities" name="Client~" id="Client~" style="width:300px;">`
        + `<datalist id="entities"></datalist></span>&ensp;`
        + `<a class='removeLink' id='removeClientLink' onclick='removeProjectField(~,"Client");return false;' href='#'>-remove</a>`
        + `</p>`;
const researcherTemplate = `<p id='addResearcher^~'>`
        + `<span class='tag'>~: </span><span id='researcher^~'>`
        + `<input list="entities" name="researcher^~" id="researcher^~" style="width:300px;">`
        + `<datalist id="entities"></datalist></span>&ensp;`
        + `<a class='removeA^Link' id='removeResearcherA^Link' onclick="removeActivityField(~,^,'Researcher');return false;" href='#'>-remove</a>`
        + `</p>`;
const contractorTemplate = `<p id='addContractor^~'>`
        + `<span class='tag'>~: </span><span id='contractor^~'>`
        + `<input list="entities" name="contractor^~" id="contractor^~" style="width:300px;">`
        + `<datalist id="entities"></datalist></span>&ensp;`
        + `<span class='tag'>Payment: $</span><span id='payment^~'><input type="number" id='payment^~' name='payment^~' min="1" step="any" style="width:100px;"></span>&ensp;`
        + `<span class='tag'>Pay date: </span><span id='pay_date^~'><input type="date" id='pay_date^~' name='pay_date^~'></span>&ensp;`
        + `<a class='removeA^Link' id='removeContractorA^Link' onclick="removeActivityField(~,^,'Contractor');return false;" href='#'>-remove</a>`
        + `</p>`;
function onloadFunctions(functionsString) {
    eval(functionsString);
}
function setProjectParam(numFunders, numClients) {
    numOfFunders = numFunders;
    numOfClients = numClients;
}
function editProject(project_code) {
    document.querySelector('a#editProject').setAttribute("onclick", "return false;");
    let id_array = ['title', 'stage', 'status', 'description', 'type', 'manager', 'start_date', 'end_date'];
    if (numOfFunders !== 0) {
        for (let i = 1; i <= numOfFunders; i++) {
            id_array.push(`funder${i}`);
            id_array.push(`funding_amt${i}`);
            id_array.push(`funder_end_date${i}`);
            id_array.push(`date_given${i}`);
        }
    }
    for (let i = 1; i <= numOfClients; i++) {
        id_array.push(`client${i}`);
    }

    for (let i = 0; i < id_array.length; i++) {
        let text = document.querySelector(`span#${id_array[i]}`).innerHTML;
        let input = "";
        if (id_array[i] === 'stage') {
            input = `<select name='${id_array[i]}' id='${id_array[i]}'>
                        <option value="Ideation">Ideation</option>
                        <option value="Proposal In Progress">Proposal in Progress</option>
                        <option value="Awaiting Funding">Awaiting Funding</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed - Not Signed Off">Completed - Not Signed Off</option>
                        <option value="Completed - Signed Off">Completed - Signed Off</option>
                    </select>`;
            input = input.replace(`>${text}<`, `selected>${text}<`);
        } else if (id_array[i] === 'status') {
            let isChecked = ["", "", ""];
            switch (text) {
                case "Red":
                    isChecked[0] = "Checked";
                    break;
                case "Yellow":
                    isChecked[1] = "Checked";
                    break;
                case "Green":
                    isChecked[2] = "Checked";
                    break;
            }
            document.querySelector(`span#${id_array[i]}`).removeAttribute("style");
            input = `<input type="radio" id="red" name="currentStatus" value="Red" ${isChecked[0]}><label class="status" for="red" style="background-color: red;"> </label> 
                    <input type="radio" id="yellow" name="currentStatus" value="Yellow" ${isChecked[1]}><label class="status" for="yellow" style="background-color: yellow;"> </label> 
                    <input type="radio" id="green" name="currentStatus" value="Green" ${isChecked[2]}><label class="status" for="green" style="background-color: green;"> </label> `;
        } else if (id_array[i] === 'description') {
            input = `<br><textarea id="${id_array[i]}" name="${id_array[i]}" rows="4" cols="60">${text}</textarea>`;
        } else if (id_array[i] === 'type') {
            input = `<input list="projectTypes" name='${id_array[i]}' id='${id_array[i]}' value="${text}">
                                    <datalist id="projectTypes">
                                        <option value="Community">
                                        <option value="Technical">
                                        <option value="Business">
                                    </datalist>`;
        } else if (id_array[i].includes('date')) {
            input = `<input type="date" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
        } else if (id_array[i].startsWith("funder") || id_array[i].startsWith("client") || id_array[i].startsWith("manager")) {
            input = `<input list="entities" name="${id_array[i]}" id="${id_array[i]}" value='${text}' style="width:300px;">
                                <datalist id="entities"></datalist>`;
        } else if (id_array[i].includes("amt")) {
            input = `<input type="number" id='${id_array[i]}' name='${id_array[i]}' value='${text}' min="1" step="any" style="width:100px;">`;
        } else {
            input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}' style="width:150px;">`;
        }
        document.querySelector(`span#${id_array[i]}`).innerHTML = input;
    }
    if (numOfFunders > 0) {
        document.querySelector(`p#addFunder${numOfFunders}`).insertAdjacentHTML("beforeend", `<a class='removeLink' id='removeFunderLink' onclick="removeProjectField(${numOfFunders},'Funder');return false;" href='#'>-remove</a>`);
    }
    if (numOfClients > 0) {
        document.querySelector(`p#addClient${numOfClients}`).insertAdjacentHTML("beforeend", `<a class='removeLink' id='removeClientLink' onclick="removeProjectField(${numOfClients},'Client');return false;" href='#'>-remove</a>`);
    }
    document.querySelector(`span#addFunderLink`).innerHTML = `<a onclick='addProjectField(${numOfFunders + 1}, "Funder");return false;' id='addLink' href='#'>+add</a>`;
    document.querySelector(`span#addClientLink`).innerHTML = `<a onclick='addProjectField(${numOfClients + 1}, "Client");return false;' id='addLink' href='#'>+add</a>`;
    document.querySelector(`div#saveEditProject`).innerHTML = `<button onclick='saveEditProject("${project_code}");return false;' style="width:200px;">Save</button>`;
}
function saveEditProject(project_code) {
    document.querySelector(`a#editProject`).setAttribute("onclick", `editProject("${project_code}");return false;`);
    document.querySelector(`span#addFunderLink`).innerHTML = ``;
    document.querySelector(`span#addClientLink`).innerHTML = ``;
    document.querySelectorAll(`.removeLink`).forEach(e => e.remove());

    let id_array = ['title', 'stage', 'status', 'description', 'type', 'manager', 'start_date', 'end_date'];
    for (let i = 1; i <= numOfFunders; i++) {
        id_array.push(`funder${i}`);
        id_array.push(`funding_amt${i}`);
        id_array.push(`funder_end_date${i}`);
        id_array.push(`date_given${i}`);
    }
    for (let i = 1; i <= numOfClients; i++) {
        id_array.push(`Client${i}`);
    }

    const data = [project_code];
    for (let i = 0; i < id_array.length; i++) {
        if (id_array[i] === 'stage') {
            data.push(document.querySelector(`select#${id_array[i]}`).value);
            document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`select#${id_array[i]}`).value;
        } else if (id_array[i] === 'status') {
            let color = "";
            if (document.getElementById('red').checked) {
                color = "Red";
                data.push(color);
            } else if (document.getElementById('yellow').checked) {
                color = "Yellow";
                data.push(color);

            } else if (document.getElementById('green').checked) {
                color = "Green";
                data.push(color);
            }
            document.querySelector(`span#${id_array[i]}`).innerHTML = color;
            document.querySelector(`span#${id_array[i]}`).setAttribute("style", `background-color: ${color};`);
        } else if (id_array[i] === 'description') {
            data.push(document.querySelector(`textarea#${id_array[i]}`).value);
            document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`textarea#${id_array[i]}`).value;
        } else if (id_array[i] === 'manager') {
            let val = document.querySelector(`input#${id_array[i]}`).value;
            if (val.includes("|")) {
                data.push(val.substring(0, val.indexOf('|') - 1));
                document.querySelector(`span#${id_array[i]}`).innerHTML = val.substring(val.indexOf("|") + 1).trim();
            } else {
                data.push(val);
                document.querySelector(`span#${id_array[i]}`).innerHTML = val;
            }
        } else if (id_array[i].includes('funder') || id_array[i].includes('Client')) {
            let val = document.querySelector(`input#${id_array[i]}`).value;
            if (val.includes("|")) {
                console.log(val);
                data.push(val.substring(0, val.indexOf('|') - 1));
                document.querySelector(`span#${id_array[i]}`).innerHTML = val.substring(val.indexOf("|") + 1).trim();
            } else {
                data.push(val);
                document.querySelector(`span#${id_array[i]}`).innerHTML = val;
            }
        } else {
            data.push(document.querySelector(`input#${id_array[i]}`).value);
            document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`input#${id_array[i]}`).value;
        }
        if (id_array[i + 1] === 'funder1') {
            data.push(numOfFunders);
        }
        if (id_array[i + 1] === 'Client1') {
            data.push(numOfClients);
        }
    }
    //console.log(id_array);
    document.querySelector(`div#saveEditProject`).innerHTML = "";
    insertEditedProject(data);
}
function insertEditedProject(data) {
    const request = new XMLHttpRequest();
    request.onload = function () {
        let responseString = this.responseText;
        console.log(responseString);   
        document.querySelector(`div#saveEditProject`).innerHTML = responseString;
    };
    const fields = ['project_code', 'title', 'stage', 'status', 'description', 'type', 'project_manager', 'start_date', 'end_date'];
    let numOfFunders = data[fields.length];
    let numOfClients = data[fields.length + numOfFunders * 4 + 1];
    fields.push("numOfFunders");
    for (let i = 1; i <= numOfFunders; i++) {
        fields.push(`funder${i}`);
        fields.push(`funding_amt${i}`);
        fields.push(`funder_end_date${i}`);
        fields.push(`date_given${i}`);
    }
    fields.push("numOfClients");
    for (let i = 1; i <= numOfClients; i++) {
        fields.push(`client${i}`);
    }
    let path = "";
    for (let i = 0; i < data.length; i++) {
        path += fields[i] + "='" + data[i] + "'";
        if (i + 1 !== data.length) {
            path += "&";
        }
    }
    //console.log(path);
    request.open("GET", "saveProjectEdits.php?" + path);
    request.send();
}
function addProjectField(num, fieldName) {
    let template = "";
    if (fieldName === 'Funder') {
        numOfFunders++;
        template = funderTemplate;
    } else {
        numOfClients++;
        template = clientTemplate;
    }
    if (num !== 1) {
        document.getElementById(`remove${fieldName}Link`).remove();
    }
    element = document.getElementById(`add${fieldName}Link`);
    element.insertAdjacentHTML("beforebegin", template.replace(/~/g, num));
    element.innerHTML = `<a onclick='addProjectField(${num + 1},"${fieldName}");return false;' id='addLink' href='#'>+add</a>`;
}
function removeProjectField(num, fieldName) {
    fieldName === 'Funder' ? numOfFunders-- : numOfClients--;
    document.getElementById(`add${fieldName}${num}`).remove();
    document.getElementById(`add${fieldName}Link`).innerHTML = `<a onclick='addProjectField(${num},"${fieldName}");return false;' id="addLink" href='#'>+add</a>`;
    if (num !== 1) {
        let removeLink = `<a class='removeLink' id='remove${fieldName}Link' onclick='removeProjectField(${num - 1},"${fieldName}");return false;' href='#'>-remove</a>`;
        document.getElementById(`add${fieldName}${num - 1}`).insertAdjacentHTML("beforeend", removeLink);
    }
}
function setNumOfActivities(numActivities) {
    numOfActivities = numActivities;
}
function setActivityParam(activityNum, numResearchers, numContractors) {
    numOfResearchers [activityNum] = numResearchers;
    numOfContractors [activityNum] = numContractors;
}
function editActivity(aIndex, project_code, activity_code) {
    document.querySelector(`a#editActivity${aIndex}`).setAttribute("onclick", "return false;");
    let id_array = [`aTitle${aIndex}`, `aDescription${aIndex}`, `aNotes${aIndex}`, `a_start_date${aIndex}`, `a_end_date${aIndex}`, `pResearcher${aIndex}`];
    for (let i = 1; i <= numOfResearchers[aIndex - 1]; i++) {
        id_array.push(`researcher${aIndex}${i}`);
    }
    for (let i = 1; i <= numOfContractors[aIndex - 1]; i++) {
        id_array.push(`contractor${aIndex}${i}`);
        id_array.push(`payment${aIndex}${i}`);
        id_array.push(`pay_date${aIndex}${i}`);
    }
    for (let i = 0; i < id_array.length; i++) {
        let text = document.querySelector(`span#${id_array[i]}`).innerHTML;
        let input = "";
        if (id_array[i].includes('date')) {
            input = `<input type="date" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
        } else if (id_array[i].includes('aDescription') || id_array[i].includes('aNotes')) {
            input = `<br><textarea id="${id_array[i]}" name="${id_array[i]}" rows="4" cols="60">${text}</textarea>`;
        } else if (id_array[i].includes('contractor') || id_array[i].includes('esearcher')) {
            input = `<input list="entities" name="${id_array[i]}" id="${id_array[i]}" value='${text}' style="width:300px;">
                                <datalist id="entities"></datalist>`;
        } else if (id_array[i].includes("payment")) {
            input = `<input type="number" id='${id_array[i]}' name='${id_array[i]}' value='${text}' min="1" step="any" style="width:100px;">`;
        } else {
            input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
        }
        document.querySelector(`span#${id_array[i]}`).innerHTML = input;
    }
    if (numOfResearchers[aIndex - 1] > 0) {
        document.querySelector(`p#addResearcher${aIndex}${numOfResearchers[aIndex - 1]}`).insertAdjacentHTML("beforeend", `<a class='removeA${aIndex}Link' id='removeResearcherA${aIndex}Link' onclick="removeActivityField(${numOfResearchers[aIndex - 1]},${aIndex},'Researcher');return false;" href='#'>-remove</a>`);
    }
    if (numOfContractors[aIndex - 1] > 0) {
        document.querySelector(`p#addContractor${aIndex}${numOfContractors[aIndex - 1]}`).insertAdjacentHTML("beforeend", `<a class='removeA${aIndex}Link' id='removeContractorA${aIndex}Link' onclick="removeActivityField(${numOfContractors[aIndex - 1]},${aIndex},'Contractor');return false;" href='#'>-remove</a>`);
    }
    document.querySelector(`span#addResearcherA${aIndex}Link`).innerHTML = `<a onclick="addActivityField(${numOfResearchers[aIndex - 1] + 1},${aIndex},'Researcher');return false;" id='addA${aIndex}Link' href='#'>+add</a>`;
    document.querySelector(`span#addContractorA${aIndex}Link`).innerHTML = `<a onclick="addActivityField(${numOfContractors[aIndex - 1] + 1},${aIndex},'Contractor');return false;" id='addA${aIndex}Link' href='#'>+add</a>`;
    document.querySelector(`div#saveEditActivity${aIndex}`).innerHTML = `<button onclick='saveEditActivity(${aIndex},"${project_code}","${activity_code}");return false;' style="width:200px;">Save</button>`;
}
function addActivityField(num, aNum, fieldName) {
    let template = "";
    if (fieldName === 'Researcher') {
        numOfResearchers[aNum - 1]++;
        template = researcherTemplate;
    } else {
        numOfContractors[aNum - 1]++;
        template = contractorTemplate;
    }
    if (num !== 1) {
        document.getElementById(`remove${fieldName}A${aNum}Link`).remove();
    }
    template = template.replace(/~/g, num);
    template = template.replace(/\^/g, aNum);
    element = document.getElementById(`add${fieldName}A${aNum}Link`);
    element.insertAdjacentHTML("beforebegin", template);
    element.innerHTML = `<a onclick="addActivityField(${num + 1},${aNum},'${fieldName}');return false;" id='addA${aNum}Link' href='#'>+add</a>`;
}
function removeActivityField(num, aNum, fieldName) {
    fieldName === 'Researcher' ? numOfResearchers[aNum - 1]-- : numOfContractors[aNum - 1]--;
    document.getElementById(`add${fieldName}${aNum}${num}`).remove();
    document.getElementById(`add${fieldName}A${aNum}Link`).innerHTML = `<a onclick="addActivityField(${num},${aNum},'${fieldName}');return false;" id="addA${num}Link" href='#'>+add</a>`;
    if (num !== 1) {
        let removeLink = `<a class='removeA${aNum}Link' id='remove${fieldName}A${aNum}Link' onclick="removeActivityField(${num - 1},${aNum},'${fieldName}');return false;" href='#'>-remove</a>`;
        document.getElementById(`add${fieldName}${aNum}${num - 1}`).insertAdjacentHTML("beforeend", removeLink);
    }
}
function saveEditActivity(aIndex, project_code, activity_code) {
    document.querySelector(`a#editActivity${aIndex}`).setAttribute("onclick", `editActivity(${aIndex}, "${project_code}","${activity_code}");return false;`);
    document.querySelector(`span#addResearcherA${aIndex}Link`).innerHTML = ``;
    document.querySelector(`span#addContractorA${aIndex}Link`).innerHTML = ``;
    document.querySelectorAll(`.removeA${aIndex}Link`).forEach(e => e.remove());

    let id_array = [`aTitle${aIndex}`, `aDescription${aIndex}`, `aNotes${aIndex}`, `a_start_date${aIndex}`, `a_end_date${aIndex}`, `pResearcher${aIndex}`];
    for (let i = 1; i <= numOfResearchers[aIndex - 1]; i++) {
        id_array.push(`researcher${aIndex}${i}`);
    }
    for (let i = 1; i <= numOfContractors[aIndex - 1]; i++) {
        id_array.push(`contractor${aIndex}${i}`);
        id_array.push(`payment${aIndex}${i}`);
        id_array.push(`pay_date${aIndex}${i}`);
    }

    const data = [project_code, activity_code];
    for (let i = 0; i < id_array.length; i++) {
        if (id_array[i].includes('aDescription') || id_array[i].includes('aNotes')) {
            data.push(document.querySelector(`textarea#${id_array[i]}`).value);
            document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`textarea#${id_array[i]}`).value;
        } else if (id_array[i].startsWith('pResearcher')) {
            let val = document.querySelector(`input#${id_array[i]}`).value;
            if (val.includes("|")) {
                console.log(val);
                data.push(val.substring(0, val.indexOf('|') - 1));
                document.querySelector(`span#${id_array[i]}`).innerHTML = val.substring(val.indexOf("|") + 1).trim();
            } else {
                data.push(val);
                document.querySelector(`span#${id_array[i]}`).innerHTML = val;
            }
        } else if (id_array[i].includes('researcher') || id_array[i].includes('contractor')) {
            let val = document.querySelector(`input#${id_array[i]}`).value;
            if (val.includes("|")) {
                console.log(val);
                data.push(val.substring(0, val.indexOf('|') - 1));
                document.querySelector(`span#${id_array[i]}`).innerHTML = val.substring(val.indexOf("|") + 1).trim();
            } else {
                data.push(val);
                document.querySelector(`span#${id_array[i]}`).innerHTML = val;
            }
        } else {
            data.push(document.querySelector(`input#${id_array[i]}`).value);
            document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`input#${id_array[i]}`).value;
        }
        if (id_array[i + 1] === `researcher${aIndex}1`) {
            data.push(numOfResearchers[aIndex - 1]);
        }
        if (id_array[i + 1] === `contractor${aIndex}1`) {
            data.push(numOfContractors[aIndex - 1]);
        }
    }
//    console.log(id_array);
//    console.log(data);
    document.querySelector(`div#saveEditActivity${aIndex}`).innerHTML = "";
    insertEditedActivity(data, aIndex);
}
function insertEditedActivity(data, aIndex) {
    const request = new XMLHttpRequest();
    request.onload = function () {
        let responseString = this.responseText;
        console.log(responseString);
        document.querySelector(`div#saveEditActivity${aIndex}`).innerHTML = responseString;
    };
    const fields = ['project_code', 'activity_code', 'title', 'description', 'notes', 'start_date', 'end_date', 'principal_researcher'];
    let numOfResearchers = data[fields.length];
    let numOfContractors = data[fields.length + numOfResearchers + 1];
    fields.push("numOfResearchers");
    for (let i = 1; i <= numOfResearchers; i++) {
        fields.push(`researcher${i}`);
    }
    fields.push("numOfContractors");
    for (let i = 1; i <= numOfContractors; i++) {
        fields.push(`contractor${i}`);
        fields.push(`payment${i}`);
        fields.push(`date_payed${i}`);
    }

    let path = "";
    for (let i = 0; i < data.length; i++) {
        path += fields[i] + "='" + data[i] + "'";
        if (i + 1 !== data.length) {
            path += "&";
        }
    }
    //console.log(path);
    request.open("GET", "saveActivityEdits.php?" + path);
    request.send();
}