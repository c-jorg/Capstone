function displayByYear(div, year, query){
	var xmlhttp = new XMLHttpRequest();
	var yearNum = document.getElementById(year).value;
	
	xmlhttp.onreadystatechange = function() {
		console.log("Ready state: " + xmlhttp.readyState + ", status: " + xmlhttp.status);
		if(xmlhttp.readyState != 4 && xmlhttp.status == 200){
			document.getElementById(div).innerHTML = "Checking..";
		}else if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById(div).innerHTML = xmlhttp.responseText;
		}else {
			document.getElementById(div).innerHTML = "Error ocurred.";
		}
	}
	xmlhttp.open("GET", "financialQueries.php?year="+yearNum+"&query="+query,true);
	xmlhttp.send();
}