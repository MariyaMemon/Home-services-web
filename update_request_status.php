<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["requestId"], $_POST["status"])) {
        $requestId = $_POST["requestId"];
        $status = $_POST["status"];

        // Update status in the database
        $updateSql = "UPDATE `service request` SET status = ? WHERE request_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $status, $requestId);

        if ($updateStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Status updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update status"]);
        }

        $updateStmt->close();
    }
}
?>
