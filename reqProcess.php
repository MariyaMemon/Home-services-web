<?php
// Include your database connection file here
include 'db_connection.php';
session_start();

// Assuming you have a database connection named $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $selectedProviderId = $_POST['selectedProviderId'];
    $selectedServiceId = $_POST['selectedServiceId'];
    $description = $_POST['description'];
    $requestAddress = isset($_POST['hiddenRequestAddress']) ? $_POST['hiddenRequestAddress'] : '';
    $dateTime = $_POST['date'];

    // Assuming you have a user session or information to get the user email or contact
    if (isset($_SESSION['user_data']['email']) && !empty($_SESSION['user_data']['email'])) {
        $userEmail = $_SESSION['user_data']['email'];
        $userIdQuery = "SELECT user_id FROM users WHERE email = ?";
    } elseif (isset($_SESSION['user_data']['contact']) && !empty($_SESSION['user_data']['contact'])) {
        $userContact = $_SESSION['user_data']['contact'];
        $userIdQuery = "SELECT user_id FROM users WHERE contact = ?";
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid user session.'));
        exit;
    }

    // Fetch user ID from the database
    $stmtUserId = $conn->prepare($userIdQuery);
    $stmtUserId->bind_param("s", $userEmail);
    $stmtUserId->execute();
    $stmtUserId->bind_result($userId);
    $stmtUserId->fetch();
    $stmtUserId->close();

    $selectedServiceName = $_POST['selectedService'];
    $serviceIdQuery = "SELECT service_id FROM services WHERE service_name = ?";
$stmtServiceId = $conn->prepare($serviceIdQuery);

if (!$stmtServiceId) {
    die('Error in preparing the service ID query: ' . $conn->error);
}

$stmtServiceId->bind_param("s", $selectedServiceName);
$stmtServiceId->execute();

if ($stmtServiceId->error) {
    die('Error executing the service ID query: ' . $stmtServiceId->error);
}

$stmtServiceId->bind_result($serviceId);
$stmtServiceId->fetch();
$stmtServiceId->close();



    // Insert data into the service_requests table
    $insertQuery = "INSERT INTO `service request` (user_id, providers_id, service_id, description, request_address, time_dates)
                    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiisss", $userId, $selectedProviderId,   $selectedServiceId, $description, $requestAddress, $dateTime);

    if ($stmt->execute()) {
        echo json_encode(array('Request sent successfully.'));
    } else {
        echo json_encode(array('Error sending request.'));
    }

    $stmt->close();
} else {
    echo json_encode(array( 'Invalid request method.'));
}
?>
