<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    include 'db_connection.php';

    // Get the new password from the form data
    $newPassword = $_POST['new_password'];

    // Perform validation if needed

    // Hash the new password before storing it
    $hashedPassword = !empty($newPassword) ? password_hash($newPassword, PASSWORD_DEFAULT) : null;

    // Update the password in the database
    $identifier = !empty($_SESSION['user_data']['email']) ? 'email' : 'contact';
    $identifierValue = $_SESSION['user_data'][$identifier];

    if (!empty($hashedPassword)) {
        $updatePasswordSql = "UPDATE users SET password=? WHERE $identifier=?";
        $updatePasswordStmt = $conn->prepare($updatePasswordSql);
        $updatePasswordStmt->bind_param("ss", $hashedPassword, $identifierValue);
        $updatePasswordResult = $updatePasswordStmt->execute();
        $updatePasswordStmt->close();
    }

    // Handle the profile picture update (existing code)

    if (!empty($updatePasswordResult)) {
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save changes in the database.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method or parameters.']);
    exit();
}
?>
