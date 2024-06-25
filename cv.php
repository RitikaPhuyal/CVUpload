<?php
session_start();
require 'connection.php';


function sendNotification($email, $message) {
    global $conn;
    $timestamp = date('Y-m-d H:i:s');
    $adjusted_time = date('Y-m-d H:i:s', strtotime('now'));

    $insert_query = "INSERT INTO notifications (email, message, created_at) VALUES ('$email', '$message', '$adjusted_time')";
    if (mysqli_query($conn, $insert_query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST["dismiss"])) {
    $id = $_POST["dismiss"];
    mysqli_query($conn, "DELETE FROM tb_upload WHERE id = $id");
}

if (isset($_POST["hire_submitted"])) {
    $email = $_POST["hire"];
    $job_applied = $_POST["job"]; 
    $message = "You have been selected for $job_applied interview.";
    
    
    if (sendNotification($email, $message)) {
        echo "<script>
                if (confirm('Are you sure you want to hire this candidate?')) {
                    alert('Notification sent to $email: $message');
                }
              </script>";
    } else {
        echo "<script>
                alert('Failed to send notification.');
              </script>";
    }

    
    header("Location: cv.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data</title>
    <link rel="stylesheet" href="cv.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Job Applied For</th>
                            <th>CV</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $rows = mysqli_query($conn, "SELECT * FROM tb_upload ORDER BY id DESC");
                        foreach ($rows as $row):
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["job_applied"]; ?></td>
                                <td>
                                    <img src="img/<?php echo $row["image"]; ?>"
                                        onclick="openModal('<?php echo $row["image"]; ?>')"
                                        title="<?php echo $row['image']; ?>">
                                </td>
                                <td class="actions">
                                    <form action="" method="post" style="display: inline;">
                                        <input type="hidden" name="hire_submitted" value="true">
                                        <input type="hidden" name="job" value="<?php echo $row["job_applied"]; ?>">
                                        <button type="submit" name="hire" value="<?php echo $row["email"]; ?>"
                                            class="btn btn-success">Hire</button>
                                    </form>
                                    <form action="" method="post" style="display: inline;">
                                        <button type="submit" name="dismiss" value="<?php echo $row["id"]; ?>"
                                            class="btn btn-danger">Dismiss</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openModal(imageSrc) {
            window.location.href = 'modal.php?image=' + encodeURIComponent(imageSrc);
        }
    </script>
</body>
</html>
