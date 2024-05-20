<?php
session_start();
require 'connection.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = $_POST["name"];
    $email = $_POST["email"];


    
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    
   
    if (strpos($email, '@deerwalk.edu.np') !== false) {
        
        $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['email'] = $email;
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Only users from deerwalk domain can register.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Page</title>
  <link rel="stylesheet" href="./signup.css">
</head>
<body>
  <div class="signup-container">
    <h2>Signup</h2>
    <form id="signupForm" action="" method="post">
      <label>Name:</label>
      <input
        type="text"
        name="name"
        placeholder="Enter your name"
        required
      />
      <br />
      <label>Email:</label>
      <input
        type="email"
        name="email"
        placeholder="Enter your email"
        required
      />
      <br />
      <label>Phone:</label>
      <input
        type="text"
        name="phone"
        placeholder="Enter your phone number"
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
      <input type="submit" value="Signup" />
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

