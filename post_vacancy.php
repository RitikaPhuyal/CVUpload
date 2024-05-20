<?php
require 'connection.php';

$message = "";

// Function to delete a job vacancy
if (isset($_GET['delete_job'])) {
    $job_id = $_GET['delete_job'];
    $query = "DELETE FROM job_vacancies WHERE id='$job_id'";
    if (mysqli_query($conn, $query)) {
        $message = "Job deleted successfully";
    } else {
        $message = "Error deleting job";
    }
}

// Function to update a job vacancy
if (isset($_POST["edit_job"])) {
    $job_id = $_POST["job_id"];
    $job_title = $_POST["job_title"];
    $job_description = $_POST["job_description"];
    
    $query = "UPDATE job_vacancies SET job_title='$job_title', job_description='$job_description' WHERE id='$job_id'";
    if(mysqli_query($conn, $query)) {
        $message = "Job updated successfully";
    } else {
        $message = "Error updating job";
    }
}

// Fetch existing job vacancies from the database
$query = "SELECT * FROM job_vacancies";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Job Vacancies</title>
    <link rel="stylesheet" href="post_vacancy.css">
    <script>
        function showMessage(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Add Job Vacancy</h2>
        <form action="" method="post" onsubmit="showMessage('<?php echo $message; ?>')">
            <label for="job_title">Job Title:</label>
            <input type="text" name="job_title" id="job_title" required><br><br>
            <label for="job_description">Job Description:</label><br>
            <textarea name="job_description" id="job_description" rows="4" cols="50" required></textarea><br><br>
            <button type="submit" name="add_job">Add Job</button>
        </form>

        <h2>Existing Job Vacancies</h2>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li>
                    <!-- Job name and description -->
                    <form action="" method="post">
                        <input type="hidden" name="job_id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="job_title" value="<?php echo $row['job_title']; ?>" required><br>
                        <textarea name="job_description" rows="4" required><?php echo $row['job_description']; ?></textarea>
                        <!-- Update and delete buttons -->
                        <div class="button-container">
                            <button type="submit" name="edit_job">Update</button>
                            <form action="" method="get">
                                <input type="hidden" name="delete_job" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_job">Delete</button>
                            </form>
                        </div>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
