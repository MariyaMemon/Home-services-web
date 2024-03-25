<?php
if (!isset($_SESSION['provider_data'])) {
    $_SESSION['provider_data'] = array();
}


if (isset($_SESSION['provider_data']['providers_id'])) {
    
    include 'db_connection.php';

    $identifier = !empty($_SESSION['provider_data']['email']) ? 'email' : 'contact';
    $identifierValue = $_SESSION['provider_data'][$identifier];

    $selectSql = "SELECT profile_picture FROM `provider` WHERE $identifier=?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("s", $identifierValue);
    $selectStmt->execute();
    $selectStmt->bind_result($profile_picture);
    $selectStmt->fetch();
    $selectStmt->close();

    
    if ($profile_picture) {
        $_SESSION['provider_data']['profile_picture'] = $profile_picture;
    }
}
?>

