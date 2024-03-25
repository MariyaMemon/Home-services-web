<?php
include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['identifier']) && isset($data['serviceName'])) {
    $identifier = $data['identifier'];
    $serviceName = $data['serviceName'];

    $providerID = getProviderID($conn, $identifier);

    $sql = "DELETE FROM provider_services WHERE providers_id = $providerID AND service_id IN (
            SELECT service_id FROM services WHERE service_name = '$serviceName'
        )";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Service deleted successfully']);
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error, 'sql_query' => $sql]);
    }

    $conn->close();
} else {
    echo json_encode(['message' => 'Error: Invalid data']);
}

function getProviderID($conn, $identifier)
{
    $sql = "SELECT providers_id FROM provider WHERE email = '$identifier' OR contact = '$identifier'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['providers_id'];
    } else {
        die("Provider not found for email or contact: $identifier");
    }
}
?>

