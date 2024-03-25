<?php
include 'db_connection.php';

// Check if a provider ID is provided in the query parameter
$providerId = isset($_GET['provider_id']) ? $_GET['provider_id'] : null;

// Fetch provider details
$sqlProvider = "SELECT * FROM provider WHERE providers_id = ?";
$stmtProvider = $conn->prepare($sqlProvider);
$stmtProvider->bind_param("i", $providerId);
$stmtProvider->execute();
$resultProvider = $stmtProvider->get_result();

$providerDetails = $resultProvider->fetch_assoc();

$stmtProvider->close();
?>
<!-- // Check if services were retrieved successfully
if ($resultServices->num_rows > 0) {
    $services = array();

    // Fetch services and store them in an array
    while ($rowService = $resultServices->fetch_assoc()) {
        $services[$rowService['service_id']] = $rowService['service_name'];
    }
} else {
    // Handle error if services are not available
    $services = array();
}

$stmtServices->close();
?> -->