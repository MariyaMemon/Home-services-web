<?php
include 'db_connection.php';
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['services'])) {
    $servicesData = $data['services'];

    $providerId = getProviderIDFromSession($conn);

    foreach ($servicesData as $serviceInfo) {
        $serviceName = $serviceInfo['service'];
        $price = $serviceInfo['price'];

        
        $serviceID = getServiceID($conn, $serviceName);

        if (!isServiceAlreadySubmitted($conn, $providerId, $serviceID)) {
            $sql = "INSERT INTO provider_services (providers_id, service_id, price) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $providerId, $serviceID, $price);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Service submitted successfully']);
            } else {
                echo json_encode(['message' => 'Error: ' . $stmt->error, 'sql_query' => $sql]);
            }

            $stmt->close();
        } else {
            echo json_encode(['message' => 'Service is already submitted']);
        }
    }

    $conn->close();
} else {
    echo json_encode(['message' => 'Error: Incomplete data']);
}

function getProviderIDFromSession($conn)
{
    if (isset($_SESSION['provider_data']['email']) && !empty($_SESSION['provider_data']['email'])) {
        $providerEmail = $_SESSION['provider_data']['email'];
        $providerIdQuery = "SELECT providers_id FROM provider WHERE email = ?";
    } elseif (isset($_SESSION['provider_data']['contact']) && !empty($_SESSION['provider_data']['contact'])) {
        $providerContact = $_SESSION['provider_data']['contact'];
        $providerIdQuery = "SELECT providers_id FROM provider WHERE contact = ?";
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid provider session.']);
        exit;
    }

 
    $stmtProviderId = $conn->prepare($providerIdQuery);
    $stmtProviderId->bind_param("s", $providerEmail); 
    $stmtProviderId->execute();
    $stmtProviderId->bind_result($providerId);
    $stmtProviderId->fetch();
    $stmtProviderId->close();

    return $providerId;
}

function getServiceID($conn, $serviceName)
{
    $sql = "SELECT service_id FROM services WHERE `service_name` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serviceName);
    $stmt->execute();
    $stmt->bind_result($serviceID);
    $stmt->fetch();
    $stmt->close();

    return $serviceID;
}

function isServiceAlreadySubmitted($conn, $providerID, $serviceID)
{
    $sql = "SELECT * FROM provider_services WHERE providers_id = ? AND service_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $providerID, $serviceID);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}
?>
