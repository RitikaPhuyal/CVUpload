<?php
require 'connection.php';

$query = "SELECT * FROM job_vacancies";
$result = mysqli_query($conn, $query);
if (!$result) {
    // If there's an error in the query execution, handle it
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $job_listings = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $job_listings = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Vacancies</title>
    <link rel="stylesheet" href="vacancy.css">
</head>
<body>
    <h2>Job Vacancies</h2>

    <div class="job-listings">
        <?php foreach ($job_listings as $job): ?>
            <div class="job">
                <h3><?php echo $job['job_title']; ?></h3>
                <p>Description: <?php echo $job['job_description']; ?></p>
                <!-- Updated link to point to form.php -->
                <a href="form.php?job_title=<?php echo urlencode($job['job_title']); ?>">Apply Now</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
