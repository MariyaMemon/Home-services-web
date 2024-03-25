
<?php
// Include your database connection file
include 'db_connection.php';

// Read data from the request body
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['service_id'], $data['updatedPrice'])) {
    $serviceId = $data['service_id'];
    $updatedPrice = $data['updatedPrice'];

    // Update the price in the database
    $updateQuery = "UPDATE provider_services SET price = ? WHERE service_id = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    // Bind parameters
    $stmtUpdate->bind_param("di", $updatedPrice, $serviceId);
    
    if ($stmtUpdate->execute()) {
        $response = ['status' => 'success', 'message' => 'Price updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error updating price: ' . $stmtUpdate->error];
    }

    $stmtUpdate->close();
} else {
    $response = ['status' => 'error', 'message' => 'Invalid data provided'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>

