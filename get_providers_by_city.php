<?php
include 'db_connection.php';
$selectedCity = isset($_GET['city']) ? $_GET['city'] : null;

if ($selectedCity) {
    $sql = "SELECT p.*, ps.service_id, s.service_name, ps.cityName, ps.price,
                   AVG(r.rating) AS averageRating
            FROM `provider` p
            LEFT JOIN `provider_services` ps ON p.providers_id = ps.providers_id
            LEFT JOIN `services` s ON ps.service_id = s.service_id
            LEFT JOIN `reviews` r ON p.providers_id = r.providers_id
            WHERE ps.cityName = ?
            GROUP BY p.providers_id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedCity);
    $stmt->execute();
    $result = $stmt->get_result();

    $providers = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($providers);
} else {
    echo json_encode([]);
}
?>
