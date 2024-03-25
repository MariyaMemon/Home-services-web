<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a type is selected
    if (isset($_POST['select']) && isset($_POST['email_contact']) && isset($_POST['new_password'])) {
        $select = $_POST['select'];
        $email_contact = $_POST['email_contact'];
        $new_password = $_POST['new_password'];
        
        // Determine table and column names based on type
        if ($select == 'user') {
            $table_name = 'users';
            $contact_column = 'contact';
            $email_column = 'email';
        } elseif ($select == 'provider') {
            $table_name = 'provider'; 
            $contact_column = 'contact';
            $email_column = 'email';
        } else {
            // Handle invalid type
            $_SESSION['reset_message'] = 'Invalid type';
            header("Location: forgetPas.php"); 
            exit;
        }

        // Prepare SQL statement
        $sql = "UPDATE $table_name SET password = ? WHERE $contact_column = ? OR $email_column = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute query
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $hashed_password, $email_contact, $email_contact);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Password reset successful
                $_SESSION['reset_message'] = 'Password reset successful!';
                header("Location: home.php"); // Redirect to the home page
                exit;
            } else {
                // No rows affected, user not found
                $_SESSION['reset_message'] = 'Password reset failed. No rows affected.';
                header("Location: forgetPas.php?error=no_rows_affected"); 
                exit;
            }

            // Close statement
            $stmt->close();
        } else {
            // Error in preparing statement
            $_SESSION['reset_message'] = 'Error in preparing statement: ' . $conn->error;
            header("Location: forgetPas.php?error=statement_error"); 
            exit;
        }
    } else {
        // Handle case where type, email_contact, or new_password is not set
        $_SESSION['reset_message'] = 'Missing parameters';
        header("Location:  forgetPas.php?error=missing_parameters"); 
        exit;
    }
} else {
    // Handle case where request method is not POST
    $_SESSION['reset_message'] = 'Invalid request method';
    header("Location: forgetPas.php?error=invalid_request_method"); 
    exit;
}
?>
