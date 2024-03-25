<?php
include 'db_connection.php';
session_start();

// Function to submit a review
function submitReview($providerId, $userId, $rating, $review) {
    global $conn;

    // TODO: Validate and sanitize input data before using it in the query

    $sql = "INSERT INTO reviews (providers_id, user_id, rating, review) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $providerId, $userId, $rating, $review);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

// Function to fetch the average review for a provider
function getAverageReview($providerId) {
    global $conn;

    // TODO: Validate and sanitize input data before using it in the query

    $sql = "SELECT AVG(rating) AS average_rating FROM reviews WHERE providers_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $providerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $averageRating = $row['average_rating'];

    $stmt->close();

    return $averageRating;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"]) && $_POST["action"] == "submit_review") {
        $providerId = $_POST["providers_id"];
        $userId = $_POST["user_id"];
        $rating = $_POST["rating"];
        $review = $_POST["review"];

        if (submitReview($providerId, $userId, $rating, $review)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to submit review"]);
        }
        exit;
    }
    if (isset($_SESSION['user_data']['email']) && !empty($_SESSION['user_data']['email'])) {
      $userEmail = $_SESSION['user_data']['email'];
      $userIdQuery = "SELECT user_id FROM users WHERE email = ?";
    } elseif (isset($_SESSION['user_data']['contact']) && !empty($_SESSION['user_data']['contact'])) {
      $userContact = $_SESSION['user_data']['contact'];
      $userIdQuery = "SELECT user_id FROM users WHERE contact = ?";
    } else {
      echo json_encode(array('status' => 'error', 'message' => 'Invalid user session.'));
      exit;
    }
    
    // Fetch user ID from the database
    $stmtUserId = $conn->prepare($userIdQuery);
    $stmtUserId->bind_param("s", $userEmail);
    $stmtUserId->execute();
    $stmtUserId->bind_result($userId);
    $stmtUserId->fetch();
    $stmtUserId->close();
}

// Handle fetching average review (you can call this function where you need it)
$selectedProviderId = /* Replace with the actual provider ID */;
$averageReview = getAverageReview($selectedProviderId);

if (isset($_GET["selectedProviderId"])) {
  $selectedProviderId = $_GET["selectedProviderId"];
  $averageReview = getAverageReview($selectedProviderId);

  // Return JSON response
  header('Content-Type: application/json');
  echo json_encode(["averageReview" => $averageReview]);
} else {
  // Return an error response if the selectedProviderId is not provided
  header('Content-Type: application/json');
  echo json_encode(["status" => "error", "message" => "selectedProviderId not provided"]);
}
?>


