<?php
session_start();
//sets username and password for session use
if ((isset($_POST["username"])) && (isset($_POST["password"]))) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
}
//verifies username and password
if ((!isset($_SESSION["username"])) || (!isset($_SESSION["password"]))) {
    $_SESSION["loginError"] = true;
    header("Location: index.php");
    exit;
}
//sql connection and query

$sha256pass = hash('sha256', $_SESSION['password']);

$connect = new mysqli("localhost:3306", "root", "", "Research");
$query = "SELECT username FROM Login WHERE username = '".$_SESSION["username"].
        "' AND password = '".$_SESSION['password']."'";

//$query = "SELECT username FROM Login WHERE username = '".$_SESSION["username"].
//        "' AND password = '".hash('sha256', $_SESSION['password'])."'";

$result = mysqli_query($connect, $query) or die(mysqli_error($connect));

if (mysqli_num_rows($result) == 1) {
    $username = $_SESSION['username'];
    header("Location: homepage.php");
    exit();
} else {
    $_SESSION['loginError'] = true;
    header("Location: index.php");
    exit();
}
?>