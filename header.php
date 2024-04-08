<?php
session_start();
/*
$_SESSION['username'] = 'test';
if (isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
}
*/

if ((!isset($_SESSION["username"])) || (!isset($_SESSION["password"]))) {
    $_SESSION["loginError"] = true;
    header("Location: index.php");
    exit;
}

//above is temporary while making stuff work
$header = "<ul class='headerUl' id='headerUl' name='headerUl'>
<li class='headerLi' id='homeLi' name='homeLi'><a class='headerA' id='homeA' name='homeA' href='index.html'>Home</a></li>
<li class='headerLi' id='fundersLi' name='fundersLi'><a class='headerA' id='fundersA' name='fundersA' href='funders.html'>Funders</a></li>
<li class='headerLi' id='projectsLi' name='projectsLi'><a class='headerA' id='projectsA' name='projectsA' href='projects.html'>Projects</a></li>
<li class='headerLi' id='usernameLi' name='usernameLi'><a class='headerA' id='usernameA' name='usernameA'>".$_SESSION['username']."</a></li>
</ul>";

echo $header;
?>
