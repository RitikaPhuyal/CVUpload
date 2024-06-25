<?php
require 'connection.php';

if(isset($_POST["signup"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM form_users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $signupError = "Username already exists";
        header("Location: form-signup.php?error=" . urlencode($signupError));
        exit();
    } else {
        $insertQuery = "INSERT INTO form_users (username, password) VALUES ('$username', '$password')";
        if(mysqli_query($conn, $insertQuery)) {
            header("Location: form-login.php");
            exit();
        } else {
            $signupError = "Error occurred while signing up";
            header("Location: form-signup.php?error=" . urlencode($signupError));
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <?php
        if(isset($_GET['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>
        <form action="form-signup.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit" name="signup">Signup</button>
        </form>
    </div>
</body>
</html>
