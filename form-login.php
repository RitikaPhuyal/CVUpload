<?php
session_start();
require 'connection.php';

if(isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM form_users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        // If a matching user is found, set session variable and redirect to job application form
        $_SESSION["username"] = $username;
        header("Location:vacancy.php");
        exit();
    } else {
        // If no matching user is found, redirect back to login with error message
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
        <h2>Login</h2>
        <form action="vacancy.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
