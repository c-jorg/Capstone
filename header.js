function displayHeader(){
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState != 4 && xmlhttp.status == 200){
			document.getElementById('header').innerHTML = 'Validating..';
		} else if (xmlhttp.readyState == 4 && xmlhttp.status == 20){
			document.getElementById('header').innerHTML = xmlhttp.responseText;
		} else {
			document.getElementById('header').innerHTML = "Error Occurred. <a href='login.html'>Reload or Try Again</a>";
		}	
	}
	xmlhttp.open("GET", "header.php");
	xmlhttp.send();
}