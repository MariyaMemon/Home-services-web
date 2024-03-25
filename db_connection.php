<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "home";
$db_port = 3306;

$conn = new mysqli($servername, $username, $password, $database, $db_port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>