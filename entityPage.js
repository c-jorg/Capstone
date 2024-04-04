function editEntity(id) {
    document.querySelector('a#editEntity').setAttribute("onclick", "return false;");
    let id_array = ['salutation', 'firstName', 'lastName', 'company', 'email', 'category'];

    for (let i = 0; i < id_array.length; i++) {
        let text = document.querySelector(`span#${id_array[i]}`).innerHTML;
        let input = "";
        if (id_array[i] === 'salutation') {
            input = `<select name="${id_array[i]}" id="${id_array[i]}">
                <option value="None">None</option>
                <option value="Mr.">Mr.</option>
                <option value="Mrs.">Mrs.</option>
                <option value="Miss">Miss</option>
                <option value="Ms.">Ms.</option>
                <option value="Dr.">Dr.</option>
            </select>`;
            input = input.replace(`>${text}<`, `selected>${text}<`);
        } else if (id_array[i] === 'category') {
            input = `<select name="${id_array[i]}" id="${id_array[i]}">
                <option value="None">None</option>
                <option value="Student - Undergraduate">Student - Undergraduate</option>
                <option value="Student - Masters">Student - Masters</option>
                <option value="Student - PhD">Student - PhD</option>
                <option value="Student - Other">Student - Other</option>
            </select>`;
            input = input.replace(`>${text}<`, `selected>${text}<`);
        } else {
            input = `<input type="text" id='${id_array[i]}' name='${id_array[i]}' value='${text}' style="width:150px;">`;
        }
        document.querySelector(`span#${id_array[i]}`).innerHTML = input;
    }
    document.querySelector(`div#saveEditEntity`).innerHTML = `<button onclick='saveEditEntity("${id}");return false;' style="width:200px;">Save</button>`;
}
function saveEditEntity(id) {
    document.querySelector(`#emailEmpty`).innerHTML = "";
    if (!document.querySelector(`input#email`).value.trim()) {
        document.querySelector(`#emailEmpty`).innerHTML = " Must provide an email address";
    } else {
        document.querySelector(`a#editEntity`).setAttribute("onclick", `editEntity("${id}");return false;`);
        let id_array = ['salutation', 'firstName', 'lastName', 'company', 'email', 'category'];
        const data = [id];
        for (let i = 0; i < id_array.length; i++) {
            if (id_array[i] === 'salutation' || id_array[i] === 'category') {
                data.push(document.querySelector(`select#${id_array[i]}`).value);
                document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`select#${id_array[i]}`).value;
            } else {
                data.push(document.querySelector(`input#${id_array[i]}`).value);
                document.querySelector(`span#${id_array[i]}`).innerHTML = document.querySelector(`input#${id_array[i]}`).value;
            }
        }
        console.log(id_array);
        document.querySelector(`div#saveEditEntity`).innerHTML = "";
        insertEditedEntity(data);
    }
}
function insertEditedEntity(data) {
    const request = new XMLHttpRequest();
    request.onload = function () {
        let responseString = this.responseText;
        console.log(responseString);
        document.querySelector(`div#saveEditEntity`).innerHTML = responseString;
    };
    const fields = ['id', 'salutation', 'first_name', 'last_name', 'company', 'email', 'category'];
    let path = "";
    for (let i = 0; i < data.length; i++) {
        path += fields[i] + "='" + data[i] + "'";
        if (i + 1 !== data.length) {
            path += "&";
        }
    }
    console.log(path);
    request.open("GET", "saveEntityEdits.php?" + path);
    request.send();
}