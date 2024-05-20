<?php
require 'connection.php';

// Fetch job vacancies from the database
$query = "SELECT * FROM job_vacancies";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$job_options = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Store job options in an array
        $job_options[] = $row['job_title'];
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
    <input type="text" name="name" id="name" required value=""><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required value="" required><br>

    <label for="job">Job:</label>
    <select name="job" id="job" required>
        <option value="">Select a job</option>
        <?php foreach ($job_options as $job): ?>
            <option value="<?php echo $job; ?>"><?php echo $job; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="image">Image:</label>
    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required><br><br>

    <button type="submit" name="submit">Submit</button>
  </form>
</body>
</html>
