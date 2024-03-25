<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['upload_picture'])) {
        include 'db_connection.php';

        $file_name = $_FILES['upload_picture']['name'];
        $file_tmp = $_FILES['upload_picture']['tmp_name'];

        $upload_directory = 'uploads/';

        move_uploaded_file($file_tmp, $upload_directory . $file_name);

        if ($_SESSION['provider_data']['profile_picture'] !== $upload_directory . $file_name) {
            $_SESSION['provider_data']['profile_picture'] = $upload_directory . $file_name;

            $identifier = !empty($_SESSION['provider_data']['email']) ? 'email' : 'contact';
            $identifierValue = $_SESSION['provider_data'][$identifier];

            $updateSql = "UPDATE `provider` SET profile_picture=? WHERE $identifier=?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $_SESSION['provider_data']['profile_picture'], $identifierValue);
            $updateStmt->execute();
            $updateStmt->close();

            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, 'error' => 'No change in profile picture.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'File not received.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit();
}
?>