<?php
include 'db_connection.php';

// Fetch accepted and pending appointment requests data from the database
$sql = "SELECT sr.*, u.user_name, s.service_name
        FROM `service request` sr
        JOIN `users` u ON sr.user_id = u.user_id
        JOIN `services` s ON sr.service_id = s.service_id
        WHERE sr.providers_id = ? AND (sr.status = 'accepted' OR sr.status IS NULL)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $providerId); // Replace with the actual provider ID
$stmt->execute();
$result = $stmt->get_result();

// Check for errors
if (!$result) {
    echo "Error: " . $conn->error;
} else {
    // Display the list of accepted and pending appointments
    if ($result->num_rows > 0) {
        echo '<ul>';

        while ($row = $result->fetch_assoc()) {
            echo '<li>';
            echo '<div class="appointment-details">';
            echo 'User: ' . $row['user_name'] . '<br>';
            echo 'Service: ' . $row['service_name'] . '<br>';
            echo 'Date: ' . $row['time_dates'] . '<br>';
            echo 'Description: ' . $row['description'] . '<br>';
            echo 'Status: ' . ($row['status'] ? $row['status'] : 'Pending') . '<br>';
            echo '</div>';
            echo '</li>';
        }

        echo '</ul>';
    } 
}
?>

