<?php
// include 'db_connection.php';

// // fetch_provider.php

// // Include your database connection code here

// $selectedProviderIdentifier = $_GET['providerIdentifier']; // Assuming you pass the identifier as a GET parameter

// $sql = "SELECT p.*, ps.service_id, s.service_name 
//         FROM `provider` p
//         LEFT JOIN `provider_services` ps ON p.providers_id = ps.providers_id
//         LEFT JOIN `services` s ON ps.service_id = s.service_id
//         WHERE p.email = '$selectedProviderIdentifier' OR p.contact = '$selectedProviderIdentifier'
//         LIMIT 1";

// $result = $conn->query($sql);

// if ($result && $result->num_rows > 0) {
//     $provider = array();

//     while ($row = $result->fetch_assoc()) {
//         $provider['user_name'] = $row['user_name'];
//         $provider['profile_picture'] = !empty($row['profile_picture']) ? $row['profile_picture'] : 'default-person-icon.png';
//         $provider['services'][] = array(
//             'service_id' => $row['service_id'],
//             'service_name' => $row['service_name'],
//         );
//     }

//     // Return JSON response
//     echo json_encode($provider);
// } else {
//     // Return empty response or handle error
//     echo json_encode(array('error' => 'Provider not found'));
// }
?>


