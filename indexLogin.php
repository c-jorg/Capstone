<!DOCTYPE html>
<link rel='stylesheet' href='loginStyle.css'
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

<div class="container">
    <img src="img/OC_Primary_Logo_Black_RGB_1080px@72ppi_Digital.png" alt='LoginLogo' style="width:100%; max-width:400px; display: block; margin: 0 auto;">	
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>
