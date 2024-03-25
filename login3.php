<?php
session_start();
include 'db_connection.php';

// Get user input
$select = isset($_POST['select']) ? $_POST['select'] : null;
$email_contact = isset($_POST['email_contact']) ? $_POST['email_contact'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

// Initialize error messages
$errors = [];

// Check if provided credentials match admin credentials
function fetchAdminDataFromDatabase($conn, $email_contact, $password) {
    $sql = "SELECT admin_name, email, password FROM admin WHERE (email = ? OR contact = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email_contact, $email_contact);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        $hashed_password = $data['password'];

        if (password_verify($password, $hashed_password)) {
            return $data;
        } else {
            return false; // Invalid password
        }
    } else {
        return false; // Admin not found
    }
}

// Admin login logic
if ($select === 'admin' || empty($select)) {
    $admin_data = fetchAdminDataFromDatabase($conn, $email_contact, $password);

    if ($admin_data) {
        $_SESSION['admin_data'] = ['email' => $admin_data['email']];
        header("Location: Admin_dashboard.php");
        exit;
    } else {
        $errors[] = "Login failed. Invalid email/contact or password.";
    }
} else {
    // User and Provider login logic
    $table_name = ($select === 'user') ? 'users' : 'provider';

    $sql = "SELECT user_name, email, contact, password, address, profile_picture FROM $table_name WHERE (email = ? OR contact = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email_contact, $email_contact);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        $hashed_password = $data['password'];

        if (password_verify($password, $hashed_password)) {
            // Redirect based on user type
            $_SESSION[$select . '_data'] = $data;
            header("Location: {$select}_dashboard.php");
            exit;
        } else {
            $errors[] = "Login failed. Invalid email/contact or password.";
        }
    } else {
        $errors[] = "Login failed. User/Provider not found.";
    }
}

// Set error messages in session
$_SESSION['login_errors'] = $errors;

// Redirect to home page
header("Location: Home.php");
exit;
?>


