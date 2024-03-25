<?php
include 'db_connection.php';

$selectedServiceId = isset($_GET['service_id']) ? $_GET['service_id'] : null;

if ($selectedServiceId) {
    $sql = "SELECT p.*, ps.service_id, s.service_name, ps.cityName, ps.price,
                   AVG(r.rating) AS averageRating
            FROM `provider` p
            LEFT JOIN `provider_services` ps ON p.providers_id = ps.providers_id
            LEFT JOIN `services` s ON ps.service_id = s.service_id
            LEFT JOIN `reviews` r ON p.providers_id = r.providers_id
            WHERE ps.service_id = ?
            GROUP BY p.providers_id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $selectedServiceId);
    $stmt->execute();
    $result = $stmt->get_result();

    $providers = $result->fetch_all(MYSQLI_ASSOC);

    if (count($providers) > 0) {
        echo json_encode($providers);
    } else {
        echo json_encode(['message' => 'No providers available for the selected service.']);
    }
} else {
    echo json_encode([]);
}
?>

