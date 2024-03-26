var numOfFunders = 0;
var numOfClients = 0;
function setProjectParam(numFunders, numClients) {
    numOfFunders = numFunders;
    numOfClients = numClients;
}
function editProject(project_code) {
    document.querySelector('a#editProject').setAttribute("onclick", "return false;");
    let id_array = ['title', 'stage', 'description', 'type', 'manager', 'start_date', 'end_date'];
    for (let i = 1; i <= numOfFunders; i++) {
        id_array.push(`funder${i}`);
        id_array.push(`funding_amt${i}`);
        id_array.push(`funder_end_date${i}`);
        id_array.push(`date_given${i}`);
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
    document.querySelector(`span#addFunderLink`).innerHTML = `<a onclick='addFunderField(${numOfFunders + 1});return false;' id='addLink' href='#'>+add</a>`;
    document.querySelector(`span#addClientLink`).innerHTML = `<a onclick="addMoreField(${numOfClients + 1}, 'Client');return false;" id='addLink' href='#'>+add</a>`;
    document.querySelector(`div#saveEditProject`).innerHTML = `<button onclick='saveEditProject("${project_code}");return false;' style="width:200px;">Save</button>`;
}

function saveEditProject(project_code) {
    document.querySelector(`a#editProject`).setAttribute("onclick", `editProject("${project_code}");return false;`);
    document.querySelector(`span#addFunderLink`).innerHTML = ``;
    document.querySelector(`span#addClientLink`).innerHTML = ``;
    document.querySelectorAll(`span#removeLink`).innerHTML = ``;
    
    let id_array = ['title', 'stage', 'description', 'type', 'manager', 'start_date', 'end_date'];
    for (let i = 1; i <= numOfFunders; i++) {
        id_array.push(`funder${i}`);
        id_array.push(`funding_amt${i}`);
        id_array.push(`funder_end_date${i}`);
        id_array.push(`date_given${i}`);
    }
    for (let i = 1; i <= numOfClients; i++) {
        id_array.push(`client${i}`);
    }
    console.log(numOfFunders,"\n\n",numOfClients);
    console.log(id_array);
    const data = [project_code];
    for (let i = 0; i < id_array.length; i++) {
        if (id_array[i] === 'stage') {
            data.push(document.querySelector(`select#${id_array[i]}`).value);
            document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`select#${id_array[i]}`).value;
        } else if (id_array[i] === 'manager' || id_array[i].includes('funder') || id_array[i].includes('client')) {
            let val = document.querySelector(`input#${id_array[i]}`).value;
            if (val.includes("|")) {
                data.push(val.substring(0, val.indexOf(" ")));
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
        if (id_array[i + 1] === 'client1') {
            data.push(numOfClients);
        }
    }
    
    document.querySelector(`div#saveEditProject`).innerHTML = "";
    console.log("BEFORE: " + data);
    insertEditedProject(data);
}
function insertEditedProject(data) {
    //console.log(data);
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
    request.open("GET", "saveProjectEdits.php?" + path);
    request.send();
}
function addFunderField(num) {
    numOfFunders++;
    const s = `<p><span class='tag'>${num}: </span><span id='funder${num}'><input list="entities" name="funder${num}" id="funder${num}" style="width:300px;">
                    <datalist id="entities"></datalist></span>&ensp;`
            + `<strong>Amount:</strong> $<span id='funding_amt${num}'><input type="number" id="funding_amt${num}" name="funding_amt${num}" min="1" step="any" style="width:100px"></span>&ensp;`
            + `<strong>Date Received:</strong> <span id='date_given${num}'><input type="date" id="date_given${num}" name="date_given${num}"></span>&ensp;`
            + `<strong>End Date:</strong> <span id='funder_end_date${num}'><input type="date" id="funder_end_date${num}" name="funder_end_date${num}"></span>
                    &ensp;
                    <span id="addFunder${num + 1}">
                            <a id='removeLink' onclick='removeFunderField(${num});return false;' href='#'>-remove</a>
                    </span></p>`;

    document.getElementById(`addFunder${num}`).innerHTML = s;
    document.querySelector(`span#addFunderLink`).innerHTML = `<a onclick='addFunderField(${num + 1});return false;' id='addLink' href='#'>+add</a>`;

}
;
function removeFunderField(num) {
    numOfFunders--;
    let s = "";
    if (num > 1) {
        s = `&ensp;<a id='removeLink' onclick='removeFunderField(${num - 1});return false;' href='#'>-remove</a>`;
    } else {
        s = "";
    }
    document.getElementById(`addFunder${num}`).innerHTML = s;
    document.getElementById(`addFunderLink`).innerHTML = `<a onclick='addFunderField(${num});return false;' id="addLink" href='#'>+add</a>`;
}
;
function addMoreField(index, fieldName) {
    if (fieldName === 'Client') {
        numOfClients++;
    }
    const s = `<p><label for="${fieldName}${index}">${fieldName} ${index}:</label>
                    <input list="entities" name="${fieldName}${index}" id="${fieldName}${index}" style="width:300px;">
                    <datalist id="entities"></datalist>
                    &ensp;
                    <span id="add${fieldName}${index + 1}">
                        <a id='removeLink' onclick="removeMoreField(${index},'${fieldName}');return false;" href='#'>-remove</a>
                    </span></p>`;
    console.log(`add${fieldName}${index}`);
    document.getElementById(`add${fieldName}${index}`).innerHTML = s;
    document.getElementById(`add${fieldName}Link`).innerHTML = `<a onclick="addMoreField(${index + 1},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;


}
;
function removeMoreField(index, fieldName) {
    if (fieldName === 'Client') {
        numOfClients--;
    }
    let s = "";
    if (index > 1) {
        s = `<a id='removeLink' onclick="removeMoreField(${index - 1},'${fieldName}');return false;" href='#'>-remove</a>`;
    } else {
        s = "";
    }
    document.getElementById(`add${fieldName}${index}`).innerHTML = s;
    document.getElementById(`add${fieldName}Link`).innerHTML = `<a onclick="addMoreField(${index},'${fieldName}');return false;" id="addLink" href='#'>+add</a>`;
}
;
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