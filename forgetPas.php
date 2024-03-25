<?php
// session_start();
// include 'db_connection.php';

// // Check if there is a reset message in the session
// if (isset($_SESSION['reset_message'])) {
//     echo '<div class="alert">' . $_SESSION['reset_message'] . '</div>';
//     unset($_SESSION['reset_message']); // Clear the session message
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<style>
     body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }

                form {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 400px;
                    width: 100%;
                }

                h2 {
                    text-align: center;
                
                }

                label {
                    display: block;
                    margin-bottom: 8px;
                }

                input {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 16px;
                    box-sizing: border-box;
                }

                select {
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 16px;
                    box-sizing: border-box;
                }

                button {
                    background-color: #4caf50;
                    color: #fff;
                    padding: 10px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    width: 100%;
                }
                button:hover{
                    background-color: #448746;
                }

                @media only screen and (max-width: 600px) {
            form {
                padding: 10px;
            }
        }
</style>
<body>
    <form action="reset_pass.php" method="post">
        <h2> Reset Password</h2>
        <select name="select" id="">
            <option value="">Select type</option>
            <option value="provider"> service provider</option>
            <option value="user">service user</option>
           </select> 
       
        <input id="email_contact" type="text" name="email_contact" placeholder="Enter your Email or Phone number" required>
        <input type='password' name='new_password' placeholder="type new password" required>
        <input type='password' name='confirm_password' placeholder="Retype password" required>
        <button type='submit'>Reset Password</button>
    </form>
   
<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if a reset message is set in the session
            let resetMessage = "<?php echo isset($_SESSION['reset_message']) ? $_SESSION['reset_message'] : '' ?>";

            // If reset message is not empty, display it as an alert
            if (resetMessage !== "") {
                alert(resetMessage);
            }

            // Clear the session variable
            <?php unset($_SESSION['reset_message']); ?>;
        });
    </script>


</body>

</html>
