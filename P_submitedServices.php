<?php
include 'db_connection.php';
session_start();
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

$providerId = getProviderIDFromSession($conn); 

$sql = "SELECT ps.service_id, s.service_name, ps.price FROM provider_services ps
        JOIN services s ON ps.service_id = s.service_id
        WHERE ps.providers_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $providerId);
$stmt->execute();

$result = $stmt->get_result();

$services = array();

while ($row = $result->fetch_assoc()) {
    $services[] = array(
        'service_id' => $row['service_id'],
        'service_name' => $row['service_name'],
        'price' => $row['price'],
    );
}

$stmt->close();

header('Content-Type: application/json');
echo json_encode($services);
?>
