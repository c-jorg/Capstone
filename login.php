<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid_username = "user123";
    $valid_password = "password123";

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        header("Location: success.html");
        exit;
    } else {
        header("Location: login.html?error=1");
        exit;
    }
} else {
    header("Location: login.html");
    exit;
}