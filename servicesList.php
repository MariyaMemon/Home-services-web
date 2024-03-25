<?php
include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['identifier'])) {
    $identifier = $data['identifier'];

    $providerID = getProviderID($conn, $identifier);

    $sql = "SELECT services.service_name FROM provider_services
            JOIN services ON provider_services.service_id = services.service_id
            WHERE provider_services.providers_id = $providerID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        echo json_encode(['services' => $services]);
    } else {
        echo json_encode(['services' => []]); 
    }

    $conn->close();
} else {
    echo json_encode(['services' => []]); 
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

