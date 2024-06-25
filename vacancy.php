<?php
session_start();
require 'connection.php';

$query = "SELECT * FROM job_vacancies";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching job vacancies: " . mysqli_error($conn));
}

$job_listings = [];
if (mysqli_num_rows($result) > 0) {
    $job_listings = mysqli_fetch_all($result, MYSQLI_ASSOC);
}


$notifications = [];
if (isset($_SESSION['username'])) {
    $user_email = $_SESSION['username'];
    $notification_query = "SELECT message, created_at FROM notifications WHERE email = '$user_email' ORDER BY created_at DESC";
    $notification_result = mysqli_query($conn, $notification_query);
    if (!$notification_result) {
        die("Error fetching notifications: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($notification_result) > 0) {
        while ($row = mysqli_fetch_assoc($notification_result)) {
            $notifications[] = $row;
        }
    }
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

    <div class="notifications">
        <h3>Notifications</h3>
        <?php if (!empty($notifications)): ?>
            <ul>
                <?php foreach ($notifications as $notification): ?>
                    <li><?php echo $notification['message']; ?> (<?php echo $notification['created_at']; ?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No new notifications.</p>
        <?php endif; ?>
    </div>

    <div class="job-listings">
        <?php foreach ($job_listings as $job): ?>
            <div class="job">
                <h3><?php echo $job['job_title']; ?></h3>
                <p>Description: <?php echo $job['job_description']; ?></p>
                <a href="form.php?job_title=<?php echo urlencode($job['job_title']); ?>">Apply Now</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
