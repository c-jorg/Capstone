<?php
$db_host = 'Research'; // Hostname of database
$db_name = 'Login';
$db_user = 'username';
$db_pass = 'password';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Your connection to our database has failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    $stmt = $pdo->prepare("SELECT password FROM Login WHERE username = $db_pass");
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
	setcookie('username', '', 0, "/");
        header("Location: index.html");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
