<?php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        header("Location: data.php"); 
        exit();
    } else {
        $loginError = "Invalid email or password";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="./login.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form id="loginForm" action="" method="post">
      <label>Email:</label>
      <input
        type="email"
        name="email"
        placeholder="Enter your email"
        required
      />
      <br />
      <label>Password:</label>
      <input
        type="password"
        name="password"
        placeholder="Enter your password"
        required
      />
      <br />
      <?php if(isset($loginError)): ?>
      <p class="error"><?php echo $loginError; ?></p>
      <?php endif; ?>
      <input type="submit" value="Login" />
    </form>
    <button onclick="goBack()">Back</button>

    <script>
      function goBack() {
        window.location.href = "index.php";
      }
    </script>
  </div>
</body>
</html>
