<?php
use function CommonMark\Render\HTML;
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

    $hashPass = hash('SHA256', $password);

    $stmt = $pdo->prepare("SELECT password FROM Login WHERE username = :username");
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

