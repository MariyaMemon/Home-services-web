<?php
// average_rating.php

// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['providers_id'])) {
  $providerId = $_GET['providers_id'];

  // Fetch average rating for the provider from the database
  $sql = "SELECT AVG(rating) AS averageRating FROM reviews WHERE providers_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $providerId);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $averageRating = $row['averageRating'];

  // Return the average rating as JSON response
  echo json_encode(['averageRating' => $averageRating]);
} else {
  // Return an error response for invalid requests
  echo json_encode(['error' => 'Invalid request']);
}
?>
