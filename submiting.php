<?php
include 'db_connection.php';


$data = json_decode(file_get_contents("php://input"), true);

if (isset($data) && is_array($data)) {
    $emailContact = isset($data['email_contact']) ? $data['email_contact'] : null;
    $serviceName = isset($data['service_name']) ? $data['service_name'] : null;
    

   
    $providerID = getProviderID($conn, $emailContact);

    
    $serviceID = getServiceID($conn, $serviceName);

   
    if (!isServiceAlreadySubmitted($conn, $providerID, $serviceID)) {

        
        $sql = "INSERT INTO provider_services (providers_id, service_id) VALUES ($providerID, $serviceID)";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['message' => 'Service submitted successfully']);
        } else {
            echo json_encode(['message' => 'Error: ' . $conn->error, 'sql_query' => $sql]);
        }
    } else {
       
        echo json_encode(['message' => 'Service is already submitted']);
    }

    $conn->close();
} 

function getProviderID($conn, $emailContact)
{
    $sql = "SELECT providers_id FROM provider WHERE email = '$emailContact' OR contact = '$emailContact'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['providers_id'];
    } else {
       
        die("Provider not found for email or contact: $emailContact");
    }
}


function getServiceID($conn, $serviceName)
{
    $sql = "SELECT service_id FROM services WHERE `service_name` = '$serviceName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['service_id'];
    } else {
        
        die("Service not found for service name: $serviceName");
    }
}


function isServiceAlreadySubmitted($conn, $providerID, $serviceID)
{
    $sql = "SELECT * FROM provider_services WHERE providers_id = $providerID AND service_id = $serviceID";
    $result = $conn->query($sql);

    return $result->num_rows > 0;
}
?>

