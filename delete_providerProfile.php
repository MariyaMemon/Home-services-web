<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_profile'])) {
    include 'db_connection.php';

    // Set profile picture to default
    $_SESSION['provider_data']['profile_picture'] = 'default-person-icon.png';

    $identifier = !empty($_SESSION['provider_data']['email']) ? 'email' : 'contact';
    $identifierValue = $_SESSION['provider_data'][$identifier];

    $updateSql = "UPDATE `provider` SET profile_picture=? WHERE $identifier=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $_SESSION['provider_data']['profile_picture'], $identifierValue);
    $updateResult = $updateStmt->execute();
    $updateStmt->close();

    if ($updateResult) {
        // Profile picture successfully set to default

        if ($_SESSION['provider_data']['profile_picture'] !== 'default-person-icon.png') {
            unlink($_SESSION['provider_data']['profile_picture']);
        }

        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update profile picture in the database.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method or parameters.']);
    exit();
}
?>
