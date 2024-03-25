<?php
include('db_connection.php');

if (isset($_GET['city'])) {
    $selectedCity = $_GET['city'];

    // Prepare and execute the SQL query
    $query = "SELECT DISTINCT s.service_name AS service_name
    FROM services s
    JOIN provider_services ps ON s.service_id = ps.service_id
    WHERE ps.cityName = ?;
    ";

    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error in preparing the query: " . $conn->error);
    }

    $stmt->bind_param('s', $selectedCity);

    if (!$stmt->execute()) {
        die("Error in executing the query: " . $stmt->error);
    }

    $result = $stmt->get_result();

    // Fetch and return the results as an array
    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row['service_name'];
    }

    echo json_encode($services);

    // Close the statement
    $stmt->close();
} else {
    // Handle the case when the 'city' parameter is not set
    echo json_encode([]);
}

// Close the database connection
$conn->close();
