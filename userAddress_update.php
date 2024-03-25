<?php

include 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = $error_message = '';

if (!isset($_SESSION['user_data'])) {
    $_SESSION['user_data'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $address = isset($_POST['address']) ? $_POST['address'] : null;

    
    $identifier = !empty($_SESSION['user_data']['email']) ? 'email' : 'contact';
    $identifierValue = $_SESSION['user_data'][$identifier];

    
    if ($address !== null) {
       
        $updateSql = "UPDATE users SET address=? WHERE $identifier=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $address, $identifierValue);

        if ($updateStmt->execute()) {
            $success_message = 'Address updated successfully.';
            $_SESSION['user_data']['address'] = $address;
        } else {
            $error_message = 'Error updating address: ' . $updateStmt->error;
            error_log('Error updating address: ' . $updateStmt->error);
        }

        $updateStmt->close();
    }
}
?>

