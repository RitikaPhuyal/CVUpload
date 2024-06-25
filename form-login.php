<?php
session_start();
require 'connection.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM form_users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        
        $_SESSION["username"] = $username;
        header("Location: vacancy.php");
        exit();
    } else {
        
        $loginError = "Invalid username or password";
        header("Location: login.php?error=" . urlencode($loginError));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="form-login.css">
</head>

<body>
    <div class="login-container">
        <h2>User Login</h2>
        <form action="form-login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>

</html>