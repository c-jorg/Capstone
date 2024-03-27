//<<<<<<<<<<jQuery
$(document).ready(() => {
    loadEntities();
    $("button#addEntityBTN").click(() => { loadEntities(); });
    $("a#addLink").click(() => { loadEntities(); });
    $("a#editProject").click(() => { loadEntities(); });
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
var numOfResearchers = 0;
var numOfContractors = 0;
const funderTemplate = `<p id='addFunder~'>`
            + `<span class='tag'>~: </span><span id='funder~'><input list="entities" name="funder~" id="funder~" style="width:300px;">
                <datalist id="entities"></datalist></span>&ensp;`
            + `<strong>Amount:</strong> $<span id='funding_amt~'><input type="number" id="funding_amt~" name="funding_amt~" min="1" step="any" style="width:100px"></span>&ensp;`
            + `<strong>Date Received:</strong> <span id='date_given~'><input type="date" id="date_given~" name="date_given~"></span>&ensp;`
            + `<strong>End Date:</strong> <span id='funder_end_date~'><input type="date" id="funder_end_date~" name="funder_end_date~"></span>&ensp;`
            + `<a class='removeLink' onclick='removeProjectField(~,"Funder");return false;' href='#'>-remove</a>`
            + `</p>`;
const clientTemplate = `<p id='addClient~'>`
        + `<span class='tag'>~: </span><span id='Client~'>`
        + `<input list="entities" name="Client~" id="Client~" style="width:300px;">`
        +  `<datalist id="entities"></datalist></span>&ensp;`
        + `<a class='removeLink' onclick='removeProjectField(~,"Client");return false;' href='#'>-remove</a>`
        +  `</p>`;
function setProjectParam(numFunders, numClients) {
    numOfFunders = numFunders;
    numOfClients = numClients;}
function editProject(project_code) {
    document.querySelector('a#editProject').setAttribute("onclick", "return false;");
    let id_array = ['title', 'stage', 'description', 'type', 'manager', 'start_date', 'end_date'];
    if(numOfFunders === 0) {
        
    } else {
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
        } else if (id_array[i] === 'type') {
            input = `<input list="projectTypes" name='${id_array[i]}' id='${id_array[i]}' value="${text}">
                                    <datalist id="projectTypes">
                                        <option value="Community">
                                        <option value="Technical">
                                        <option value="Business">
                                    </datalist>`;
        } else if (id_array[i].includes("funder_end_date")) {
            input = `<input type="date" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
        } else if (id_array[i].startsWith("funder") || id_array[i].startsWith("client") || id_array[i].startsWith("manager")) {
            input = `<input list="entities" name="${id_array[i]}" id="${id_array[i]}" value='${text}' style="width:300px;">
                                <datalist id="entities"></datalist>`;
        } else if (id_array[i].includes("date")) {
            input = `<input type="date" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
        } else if (id_array[i].includes("amt")) {
            input = `<input type="number" id='${id_array[i]}' name='${id_array[i]}' value='${text}' min="1" step="any" style="width:100px;">`;
        } else {
            input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}' style="width:150px;">`;
        }
        document.querySelector(`span#${id_array[i]}`).innerHTML = input;
    }
    for (let i = 1; i <= numOfFunders; i++) {
        document.querySelector(`p#addFunder${i}`).insertAdjacentHTML("beforeend",`<a class='removeLink' onclick="removeProjectField(${i},'Funder');return false;" href='#'>-remove</a>`);
    }
    for (let i = 1; i <= numOfClients; i++) {
        document.querySelector(`p#addClient${i}`).insertAdjacentHTML("beforeend",`<a class='removeLink' onclick="removeProjectField(${i},'Client');return false;" href='#'>-remove</a>`);
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
    
    let id_array = ['title', 'stage', 'description', 'type', 'manager', 'start_date', 'end_date'];
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
        } else if (id_array[i] === 'manager') {
            let val = document.querySelector(`input#${id_array[i]}`).value;
            if (val.includes("|")) {
                console.log(val);
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
    
//    let funders = document.getElementByClassName(`Funders`);
//    let funder = parent.querySelectorAll(`p#addFunder${i}`);
    
    console.log(id_array);
    document.querySelector(`div#saveEditProject`).innerHTML = "";
    insertEditedProject(data);
}
function insertEditedProject(data) {
    const request = new XMLHttpRequest();
    request.onload = function () {
        let responseString = this.responseText;
        console.log(responseString);
    };
    const fields = ['project_code', 'title', 'stage', 'description', 'type', 'project_manager', 'start_date', 'end_date'];
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
    console.log(path);
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
    element = document.getElementById(`add${fieldName}Link`);
    element.insertAdjacentHTML("beforebegin",template.replace(/~/g,num));
    element.innerHTML = `<a onclick='addProjectField(${num + 1},"${fieldName}");return false;' id='addLink' href='#'>+add</a>`;
}
function removeProjectField(num, fieldName) {
    fieldName === 'Funder' ? numOfFunders-- : numOfClients--;
    document.getElementById(`add${fieldName}${num}`).remove();
    document.getElementById(`add${fieldName}Link`).innerHTML = `<a onclick='addProjectField(${num},"${fieldName}");return false;' id="addLink" href='#'>+add</a>`;
}
function addMoreField(index, fieldName) {
    if (fieldName.includes('Client')) {
        numOfClients++;
    }
    element = document.getElementById(`add${fieldName}${index}`);
    const s = `<span class='tag'>${index}: </span><span id='${fieldName}${index}'>
                <input list="entities" name="${fieldName}${index}" id="${fieldName}${index}" style="width:300px;">
                <datalist id="entities"></datalist></span>&ensp;`;
    element.innerHTML = s;
    element.insertAdjacentHTML("beforeend",`<a class='removeLink' onclick="removeMoreField(${index},'${fieldName}');return false;" href='#'>-remove</a>`);
    element.insertAdjacentHTML("afterend",`<p id="add${fieldName}${index + 1}"></p>`);
    document.getElementById(`add${fieldName}Link`).innerHTML = `<a onclick="addMoreField(${index + 1},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;


}

function removeMoreField(index, fieldName) {
    if (fieldName === 'Client') {
        numOfClients--;
    }
    element = document.getElementById(`add${fieldName}${index}`);
    index > 1 ? element.remove() : element.innerHTML = "";

    document.getElementById(`add${fieldName}Link`).innerHTML = `<a onclick="addMoreField(${index},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;
}
//function editActivity(activityCode, cl, co, s, con) {
//    document.querySelector(`a#editActivity${activityCode}`).setAttribute("onclick", "return false;");
//    let id_array = ['activityTitle', 'activityDescription'];
//    for (let i = 1; i <= cl; i++) {
//        id_array.push(`client${i}`);
//    }
//    id_array.push(`principalResearcher`);
//    for (let i = 1; i <= co; i++) {
//        id_array.push(`coResearcher${i}`);
//    }
//    for (let i = 1; i <= s; i++) {
//        id_array.push(`student${i}`);
//    }
//    for (let i = 1; i <= con; i++) {
//        id_array.push(`contractor${i}`);
//    }
//    for (let i = 0; i < id_array.length; i++) {
//        let text = document.querySelector(`fieldset#activity${activityCode} span#${id_array[i]}`).innerHTML;
//        if (text === '') {
//            text = "abc" + Math.floor(Math.random() * 100);
//        }
//        let input = "";
//        input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}'>`;
//        document.querySelector(`fieldset#activity${activityCode} span#${id_array[i]}`).innerHTML = input;
//    }
//    document.querySelector(`div#saveEditActivity${activityCode}`).innerHTML = "<button onclick='return false;'>Save</button>";
//}
//function editField(project_code, fieldId) {
//    console.log(project_code, fieldId);
//
//    document.querySelector(`span#p` + fieldId).innerHTML = `<a onclick="saveEdit(${project_code},'${fieldId}');return false;" href="#">save</a>`;
//
//    const select = document.querySelector(`span#${fieldId}`);
//    const text = select.innerHTML;
//    let input = "";
//    if (fieldId === 'stage') {
//        input = `<select name='${fieldId}' id='${fieldId}'>
//                                <option value="Ideation">Ideation</option>
//                                <option value="Proposal In Progress">Proposal in Progress</option>
//                                <option value="Awaiting Funding">Awaiting Funding</option>
//                                <option value="In Progress">In Progress</option>
//                                <option value="Completed - Not Signed Off">Completed - Not Signed Off</option>
//                                <option value="Completed - Signed Off">Completed - Signed Off</option>
//                                </select>`;
//        input = input.replace(`>${text}<`, `selected>${text}<`);
//    } else if (fieldId === 'type') {
//        input = `<input list="projectTypes" name='${fieldId}' id='${fieldId}' value="${text}">
//                                    <datalist id="projectTypes">
//                                        <option value="Community">
//                                        <option value="Technical">
//                                        <option value="Business">
//                                    </datalist>`;
//    } else if (fieldId === 'description') {
//        input = `<br><textarea id="projectDescription" name="projectDescription" rows="4" cols="50" >${text}</textarea><br>`;
//
//    } else {
//        input = `<input type="text" id='${fieldId}' name='${fieldId}' value='${text}'>`;
//    }
//    select.innerHTML = input;
//
//    // document.querySelector(`div#saveEditProject`).innerHTML = `<button onclick='saveEditProject(${project_code},${numOfFunders});return false;'>Save</button>`;
//
//}
//function saveEdit(project_code, fieldId) {
//    document.querySelector(`span#p` + fieldId).innerHTML = `<a onclick="editField(${project_code},'${fieldId}');return false;" href="#">edit</a>`;
//    let text = "";
//    if (fieldId === 'stage') {
//        text = document.querySelector(`select#${fieldId}`).value;
//    } else if (fieldId === 'description') {
//        text = document.querySelector(`textarea#${fieldId}`).value;
//    } else {
//        text = document.querySelector(`input#${fieldId}`).value;
//    }
//    document.querySelector(`span#${fieldId}`).innerHTML = text;
//    insertEdit(project_code, fieldId, text);
//}
//function insertEdit(project_code, fieldId, text) {
//    console.log(project_code, fieldId, text);
//    const request = new XMLHttpRequest();
//    request.onload = function () {
//        let responseString = this.responseText;
//        console.log(responseString);
//    };
//    const pField = ['project_code', 'title', 'description', 'stage', 'type', 'project_manager', 'start_date', 'end_date', 'funding_amt', 'date_given', 'funder_end_date', 'first_name', 'last_name', 'email', 'salutation', 'company'];
//    let path = "saveEdits.php?";
//    for (let i = 0; i < data.length; i++) {
//        path += pField[i] + "=" + data[i];
//        if (i + 1 !== data.length) {
//            path += "&";
//        }
//    }
//    request.open("GET", path);
//    request.send();
//
//}