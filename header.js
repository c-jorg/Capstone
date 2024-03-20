function displayHeader(){
	console.log('displayHeader function called');
	var header = document.getElementById("header");
	var headerText = "<ul class='headerUl' id='headerUl' name='headerUl'><li class='headerLi' id='homeLi' name='homeLi'><a class='headerA' id='homeA' name='homeA' href='index.html'>Dashboard</a></li><li class='headerLi' id='fundersLi' name='fundersLi'><a class='headerA' id='fundersA' name='fundersA' href='fundersList.php'>Funders</a></li><li class='headerLi' id='projectsLi' name='projectsLi'><a class='headerA' id='projectsA' name='projectsA' href='projectList.php'>Projects</a></li><li class='headerLi' id='reportsLi'><a class='headerA' id='reportsA' href='reports.html'>Reports</a></li><li class='headerLi' id='usernameLi' name='usernameLi'><a class='headerA' id='usernameA' name='usernameA'>test</a></li><li class='headerLi' id='logoutLi' name='logoutLi'><a class='headerA' id='logoutA' name='logoutA' href='logout.php'>Logout</a></li></ul><br/>";
	header.innerHTML = headerText;
	console.log('displayHeader function reached end');
}
