<?php
use function CommonMark\Render\HTML;

$sqli = new mysqli('localhost:3306', 'root', '', 'Research');

// Check connection
if ($sqli->connect_error) {
    die("Connection failed: " . $sqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashPass = hash('SHA256', $password);

    $stmt = $sqli->prepare("SELECT password FROM Login WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $result = mysqli_query($conn, $sql);

    if ($row && password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['username'] = $row['username'];
        header("Location: index.html");
        exit();
    } else {
        header("Location: ftp_login.HTML?Error=invalid_credentials");
        exit();
    }

    if ($row && password_verify($row['password'], $hashPass)) {
	setcookie('username', $username, 0, "/");
        header("Location: index.html");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}


