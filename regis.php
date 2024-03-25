<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['email_contact'];
    $select = $_POST['select']; 

    $user_name = $_POST['user_name'];
    $email = null;
    $contact = null;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $registration_date = date('Y-m-d H:i:s');

    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $email = $input;
    } else {
        $input = preg_replace("/[^0-9]/", "", $input); 
        if (strlen($input) === 11) {
            $contact = $input;
        } else {
            $_SESSION['registration_errors'][] = 'Invalid email or phone number. Please enter a valid email or an 11-digit phone number.';
            header('Location: Home.php');
            exit;
        }
    }
    if (($email !== null || $contact !== null) && $user_name !== null) {
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "home";
        $db_port = 3306;

        $conn = new mysqli($servername, $db_username, $db_password, $db_name, $db_port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($select === 'user') {
            $checkSql = "SELECT user_id FROM users WHERE email = ? OR contact = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("ss", $email, $contact);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $_SESSION['registration_errors'][] = 'Email or phone number already exists for users. Please use a different one.';
                header('Location: Home.php');
                exit;
            } else {
                if (!empty($email)) {
                    $insertSql = "INSERT INTO users (user_name, email, password, registration_date) VALUES (?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertSql);
                    $insertStmt->bind_param("ssss", $user_name, $email, $password, $registration_date);
                } elseif (!empty($contact)) {
                    $insertSql = "INSERT INTO users (user_name, contact, password, registration_date) VALUES (?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertSql);
                    $insertStmt->bind_param("ssss", $user_name, $contact, $password, $registration_date);
                }
                if ($insertStmt->execute()) {                  
                    $selectSql = "SELECT user_name, email, contact, address, profile_picture FROM `users` WHERE email = ? OR contact = ?";
                    $selectStmt = $conn->prepare($selectSql);
                    $selectStmt->bind_param("ss", $email, $contact);
                    $selectStmt->execute();
                    $result = $selectStmt->get_result();
                    $user_data = $result->fetch_assoc();
                        
                    $_SESSION['user_data'] = $user_data;
                         
                    header('Location: user_dashboard.php');
                    exit;
                } else {
                    echo "Error: " . $insertStmt->error;
                }
                $insertStmt->close();
            }
        } else if ($select === 'provider') {
            $checkSql = "SELECT providers_id FROM `provider` WHERE email = ? OR contact = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("ss", $email, $contact);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $_SESSION['registration_errors'][] = 'Email or phone number already exists for providers. Please use a different one.';
                header('Location: Home.php');
                exit;
            } else {
                if (!empty($email)) {
                    $insertSql = "INSERT INTO `provider` (user_name, email, password, registration_date) VALUES (?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertSql);
                    $insertStmt->bind_param("ssss", $user_name, $email, $password, $registration_date);
                } elseif (!empty($contact)) {
                    $insertSql = "INSERT INTO `provider` (user_name, contact, password, registration_date) VALUES (?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertSql);
                    $insertStmt->bind_param("ssss", $user_name, $contact, $password, $registration_date);
                }   
                if ($insertStmt->execute()) {
                    
                    $selectSql = "SELECT user_name, email, contact, address, profile_picture FROM `provider` WHERE email = ? OR contact = ?";
                    $selectStmt = $conn->prepare($selectSql);
                    $selectStmt->bind_param("ss", $email, $contact);
                    $selectStmt->execute();
                    $result = $selectStmt->get_result();
                    $provider_data = $result->fetch_assoc();       
                  
                    $_SESSION['provider_data'] = $provider_data;
                           
                    header('Location: provider_dashboard.php');
                    exit;
                } else {
                    echo "Error: " . $insertStmt->error;
                }
                $insertStmt->close();
            }
        }
        $conn->close();
    }
}
?>

