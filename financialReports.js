function displayByYear(div, start, end, query){
	var xmlhttp = new XMLHttpRequest();
	 start = document.getElementById(start).value;
	 end = document.getElementById(end).value;
	
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
	//console.log()
	xmlhttp.open("GET", "financialQueries.php?start="+start+"&end="+end+"&query="+query,true);
	xmlhttp.send();
}

function displayCSV (){
	var xmlhttp = new XMLHttpRequest();
	window.open(href, "csvOutput.html");
	var div = "csvOutput";
	
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
	
	xmlhttp.open("GET", "readCSV.php",true);
	xmlhttp.send();
}