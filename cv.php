<?php
require 'connection.php';

function sendEmail($to, $subject, $message) {
    $headers = "From: your_email@example.com\r\n";
    $headers .= "Reply-To: your_email@example.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('Email sent successfully');</script>";
    } else {
        echo "<script>alert('Email sending failed');</script>";
    }
}

if(isset($_POST["hire"])) {
    // echo($id);
    // $result = mysqli_query($conn, "SELECT * FROM tb_upload WHERE id = $id");
    // $row = mysqli_fetch_assoc($result);
    // ini_set("SMTP","smtp.gmail.com");
    // ini_set('smtp_port', '587');
    // ini_set("sendmail_from", "ritikaphuyal68@gmail.com");
    $to = $_POST["hire"];
    $subject = "Hired for Job";
    $message = "Congratulations! You have been selected for an interview.";
    sendEmail($to, $subject, $message);
}

if(isset($_POST["dismiss"])) {
    $id = $_POST["dismiss"];
    mysqli_query($conn, "DELETE FROM tb_upload WHERE id = $id");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Data</title>
    <link rel="stylesheet" href="cv.css">
  
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>CV</th>
                            <th>Actions</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $rows = mysqli_query($conn, "SELECT * FROM tb_upload ORDER BY id DESC");
                        foreach ($rows as $row) :
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["email"]; ?> </td>
                            <td>
                                <img src="img/<?php echo $row["image"]; ?>" onclick="openModal('<?php echo $row["image"]; ?>')" title="<?php echo $row['image']; ?>">
                            </td>
                            <td class="actions"> 
                                <form action="" method="post" style="display: inline;">
                                    <button type="submit" name="hire" value="<?php echo $row["email"]; ?>" class="btn btn-success">Hire</button>
                                </form>
                                <form action="" method="post" style="display: inline;">
                                    <button type="submit" name="dismiss" value="<?php echo $row["id"]; ?>" class="btn btn-danger">Dismiss</button>
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
