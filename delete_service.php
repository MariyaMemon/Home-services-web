<?php
include 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['service_id'])) {
    $serviceId = $data['service_id'];

    $deleteQuery = "DELETE FROM provider_services WHERE service_id = ?";
    $stmtDelete = $conn->prepare($deleteQuery);
    $stmtDelete->bind_param("i", $serviceId);
    
    if ($stmtDelete->execute()) {
        $response = ['status' => 'success', 'message' => 'Service deleted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error deleting service'];
    }

    $stmtDelete->close();
} else {
    $response = ['status' => 'error', 'message' => 'Invalid data provided'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
