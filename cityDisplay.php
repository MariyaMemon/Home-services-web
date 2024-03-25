<?php
include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['identifier'])) {
    $identifier = $data['identifier'];

    $providerID = getProviderID($conn, $identifier);

   
    $sql = "SELECT cityName FROM provider_services WHERE providers_id = $providerID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cityName = $row['cityName'];
        echo json_encode(['cityName' => $cityName]);
    } else {
        echo json_encode(['cityName' => '']); 
    }

    $conn->close();
} else {
    echo json_encode(['cityName' => '']); 
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

