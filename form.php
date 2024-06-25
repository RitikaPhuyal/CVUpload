<?php
session_start();
require 'connection.php';


$query = "SELECT * FROM job_vacancies";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$job_options = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $job_options[] = $row['job_title'];
    }
}


$selected_job = isset($_GET['job_title']) ? $_GET['job_title'] : '';


if (!isset($_SESSION['username'])) {
    die("You must be logged in to access this page.");
}

$user_email = $_SESSION['username'];


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $job = $_POST['job'];
    $image = $_FILES['image']['name'];
    $target = "img/" . basename($image);

    if ($email != $user_email) {
        die("Error: You can only submit the form with your logged-in email address.");
    }
 
    $check_query = "SELECT * FROM tb_upload WHERE email = '$email' AND job_applied = '$job'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "You have already applied for this job.";
    } else {
        
        $query = "INSERT INTO tb_upload (name, email, job_applied, image) VALUES ('$name', '$email', '$job', '$image')";
        if (mysqli_query($conn, $query)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                echo "Application submitted successfully.";
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Apply Now</title>
  <link rel="stylesheet" href="form.css">
</head>
<body>
  <img src="./assets/indeximg.png" alt="">
  <h1> Job Application <span class="title-small">(Form)</span></h1>
  <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo $user_email; ?>" readonly><br>

    <label for="job">Job:</label>
    <select name="job" id="job" required>
        <option value="">Select a job</option>
        <?php foreach ($job_options as $job): ?>
            <option value="<?php echo $job; ?>" <?php echo ($job == $selected_job) ? 'selected' : ''; ?>>
                <?php echo $job; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="image">Image:</label>
    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required><br><br>

    <button type="submit" name="submit">Submit</button>
  </form>
</body>
</html>
