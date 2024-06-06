<?php
require 'connection.php';

$query = "
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "Table 'notifications' created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>
