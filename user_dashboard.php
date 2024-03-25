<?php
session_start();
 include 'db_connection.php';

if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="user.css"> 
    <link rel="stylesheet" href="profile_user.css">
    <link rel="stylesheet" href="request.css">
    <link rel="stylesheet" href="status.css">
    <link rel="stylesheet" href="history.css">
    <link rel="stylesheet" href="complaint.css">
    <link rel="stylesheet" href="rating.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
  <style>
    .container #providerProfilePictureDisplay {
      position: relative;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    background-color: #fff;
    border: 2px solid #ccc;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    margin-top: -65px;
    }
    #providerUsernameDisplay{
      font-weight: 550;
      text-transform: uppercase;
      margin-top: 1px;
    }
    .service-container {
        display: block;
        /* flex-wrap: wrap; */
        gap: 20px;
        margin:10px 5px;
    }

    .service {
        padding: 10px;
        list-style:none;
        font-family:'Times New Roman', Times, serif;
        display:block;
         border-radius: 30px; 
        border: 2px solid #ccc; 
        box-shadow: 0 0 10px rgba(0, 0, 0, 1); 
        background-color: WHITE;  
         display: inline-block; 
        font-weight:600;
        color:BLACK;
    }
     .provider-details .btn {
      background-color: rgb(248, 171, 4);
    }
    .city-container{
      font-weight:600;
      margin:15px;
      
    }
    .city{
      margin:10px;
      background-color: #e6aa06;
      padding: 8px;
      border: 20px;
      border-radius: 30px;
    }
     .note {
      font-style:italic;
      font-weight:500;
     margin-top:1px;
    }
</style>

<body>
    <div class="sidebar" id="sidebar">    
        <a href="#account">
            <i class="bx bx-user"></i>
            <span>Account Setting</span>
        </a>
        <a href="#services">
            <i class="bx bx-book-open"></i>
            <span>Services</span>
        </a>
        <a href="#status">
            <i class="bx bx-user-check"></i>
            <span>Status</span>
        </a>
         <a href="#history">
         <i class='bx bx-history'></i>
            <span>History</span>
        </a>
        <a href="#complaint">
        <i class='bx bx-error-alt' ></i>
            <span>Complaint</span>
        </a>
        <a href="#" onclick="signOut()">
            <i class="bx bx-log-out"></i>
            <span>Logout</span>
        </a>
    </div>
    <div class="content" id="content">

<?php 
include 'userAddress_update.php';
?>
        <section id="account" class="account">
        <div class="container">
        <h1>Account Settings</h1>              
        <form action="#" method="POST" enctype="multipart/form-data" >
        <div class="profile-container">
    <div class="profile-picture" id="profile-picture-container">                           
    <?php
    if (isset($_SESSION['user_data']['profile_picture'])) {
        echo '<img src="' . $_SESSION['user_data']['profile_picture'] . '" alt="">';
    } else {
        echo '<img src="default-person-icon.png" alt="">';
    }
    ?>
    </div>
    <div class="options-dropdown" id="options-dropdown">
        <button id="options-button">...</button>
        <div class="options-content" id="options-content">
            <label for="upload-input" class="upload-input">Upload</label>
            <input type="file" name="upload_picture" id="upload-input" style="display: none;" accept="image/*" onchange="updateProfilePicture(this)">
            <a href="#" onclick="deleteProfilePicture(); return false;">Delete</a>
        </div>
    </div>
</div>                       
       <input type="text" id="name" name="user_name" value=" <?php  echo $user_data['user_name']; ?>" disabled>                  
       <input type="text" id="email_contact" name="email_contact" value="<?php echo !empty($user_data['email']) ? $user_data['email'] : $user_data['contact']; ?>" 
       <?php echo (!empty($user_data['email']) ? 'readonly' : ''); ?> disabled>                                         
       <input type="text" id="address" name="address" placeholder="Enter your Address" value="<?php echo $_SESSION['user_data']['address']; ?>" >   
       <input type="password" id="password" name="new_passwod" placeholder="Update password"  >
       <input type="submit" onclick="saveChanges()" value="Save Changes">           
       </form>
       </section>


        <section id="services" class="services">
        <div class="container">                            
        <div class="inputBox"> 
        <select name="role" required="required" id="service-select">
        <option value="">Select available services</option>
        <?php
        $serviceQuery = "SELECT * FROM services";
        $serviceResult = $conn->query($serviceQuery);

        if ($serviceResult->num_rows > 0) {
        while ($serviceRow = $serviceResult->fetch_assoc()) {
        echo "<option value='{$serviceRow['service_id']}'>{$serviceRow['service_name']}</option>";
        }
        }
        ?>
        </select>
        </div>
        <div class="inputBox">
        <select name="city" name="city" id="city-select" required="required">
        <option value="">Select available city</option>
        <?php
        $sql = "SELECT DISTINCT cityName FROM `provider_services` WHERE cityName IS NOT NULL AND cityName <> ''";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['cityName'] . "'>" . $row['cityName'] . "</option>";
        }
        } 
        ?>
        </select>
        </div>
        </div>
        <div class="provider-list-section">
            <?php 
            include 'provider_List.php'; 
            ?>
        </div>

<!-- Request Form -->
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="requestModal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="requestForm" action="reqProcess.php" method="POST">
          
        <input type="hidden" id="selectedProviderId" name="selectedProviderId" value="">
         
          <div class="form-group">
            <div class="container">
              <img src="" alt="" id="providerProfilePictureDisplay" class="img-fluid">
            </div>
          </div>

          <div class="form-group">
            <p id="providerUsernameDisplay"></p>
          </div>
          <div class="form-group">
            <p id="cityName" ></p>
          </div>

         <div class="form-group">
            <select class="form-control" id="selectedService" name="selectedService" onchange="updateSelectedServiceId()" required >
              <option value="">Select service</option>
              <div id="selectedServiceList"></div>
            </select>
          </div>
          <input type="hidden" id="selectedServiceId" name="selectedServiceId">
         
          <div class="form-group">
            <input type="text" class="form-control" id="requestAddress" name="requestAddress" placeholder="Enter your Address" value=" <?php echo $_SESSION['user_data']['address']; ?>"  onchange="updateHiddenRequestAddress()"  disabled>
           
            <input type="hidden" id="hiddenRequestAddress" name="hiddenRequestAddress" value="<?php echo $_SESSION['user_data']['address']; ?>">
          </div>

          <div class="form-group">
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="description" required></textarea>
          </div>

          <div class="form-group">
    <input type="datetime-local" class="form-control" id="date" name="date" required>
</div>
            <p class="note">Note: Service charges will be recieved by service provider at your doorstep.</p>
            <button type="submit" class="btn btn-primary" onclick="sendRequest()">Send Request for service</button>
  
        </form>
      </div>
    </div>
  </div>
</div>
        </section>





        <section id="status" class="status" style="overflow-y: auto; max-height: 500px;" >
    <div class="container">
        <h1 style="color: white;">Status</h1>

        <?php
        include 'db_connection.php';

        // Add checks for user session here...

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
        $stmtUserId->bind_param("s", $userEmail); // Change this to $userContact if needed
        $stmtUserId->execute();
        $stmtUserId->bind_result($userId);
        $stmtUserId->fetch();
        $stmtUserId->close();

        $sql = "SELECT sr.*, p.user_name, s.service_name, p.profile_picture
                FROM `service request` sr
                JOIN `provider` p ON sr.providers_id = p.providers_id
                JOIN services s ON sr.service_id = s.service_id
                WHERE sr.user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          // Display the list of service requests
          echo '<ul>';
      
          while ($row = $result->fetch_assoc()) {
              echo '<li class="request-item">';
              echo '<div class="provider-profile">';
              if (!empty($row['profile_picture'])) {
                echo '<img src="' . $row['profile_picture'] . '" alt="">';
            } else {
                echo '<img src="default-person-icon.png" alt="">';
            }
            //   echo '<img src="' . $row['profile_picture'] . '" alt="">';
              echo '<div class="request-details">';
              echo '<h3>Provider: ' . $row['user_name'] . '</h3>';
              echo 'Service: ' . $row['service_name'] . ' <br>';
              echo 'Date: ' . $row['time_dates'] . ' <br>';
              echo 'Description: ' . $row['description'] . ' <br>';
              echo 'Status: ';
      
              // Add CSS class based on the status
              $statusClass = '';
      
              if ($row['status'] === null) {
                  $statusClass = 'pending';
              } elseif ($row['status'] === 'accepted') {
                  $statusClass = 'accepted';
              } elseif ($row['status'] === 'rejected') {
                  $statusClass = 'rejected';
              }
      
              echo '<span class="status-button ' . $statusClass . '">' . ($row['status'] ? $row['status'] : 'Pending') . '</span>';
              echo '</div>';
              echo '</div>';
      
              // Display cancel button if the request is pending
              if ($row['status'] === null) {
                  echo '<button class="cancel-request-btn" data-request-id="' . $row['request_id'] . '">Cancel Request</button>';
              }
      
              echo '</li>';
          }
      
          echo '</ul>';
      } else {
          echo '<p>No requests for service have been sent yet.</p>';
      }
      ?>
    </div>
</section>







<section id="history" class="history" style="overflow-y: auto; max-height: 520px;">
    <div class="container">
        <br>    
        <h1 style="color: white;">History</h1>

        <?php
        include 'db_connection.php';

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
        $stmtUserId->bind_param("s", $userEmail); // Change this to $userContact if needed
        $stmtUserId->execute();
        $stmtUserId->bind_result($userId);
        $stmtUserId->fetch();
        $stmtUserId->close();

        $sql = "SELECT sr.*, p.user_name, s.service_name, p.profile_picture, ps.cityName
        FROM `service request` sr
        JOIN `provider` p ON sr.providers_id = p.providers_id
        JOIN `provider_services` ps ON p.providers_id = ps.providers_id
        JOIN services s ON sr.service_id = s.service_id
        WHERE sr.user_id = ? AND sr.status = 'accepted'";


        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check for errors
        if (!$result) {
            echo "Error: " . $conn->error;
        } else {
            // Display the list of history
            echo '<ul>';

            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo '<div class="provider-profile">';
                if (!empty($row['profile_picture'])) {
                    echo '<img src="' . $row['profile_picture'] . '" alt="">';
                } else {
                    echo '<img src="default-person-icon.png" alt="">';
                }
                echo '<div class="history-details">';
                echo 'Provider: ' . $row['user_name'] . '<br>';
                echo 'Service: ' . $row['service_name'] . '<br>';
                echo 'Date: ' . $row['time_dates'] . '<br>';
                echo 'Description: ' . $row['description'] . '<br>';
                echo 'City: ' . $row['cityName'] . '<br>';
                echo '</div>';
                echo '</div>';
                echo '<button class="send-request-again-btn" data-toggle="modal" data-target="#requestModal" data-provider-id="' . $row['providers_id'] . '" data-provider-name="' . $row['user_name'] . '" data-service-name="' . $row['service_name'] . '" data-date="' . $row['time_dates'] . '" data-description="' . $row['description'] . '" data-profile-picture="' . $row['profile_picture'] . '" data-city="' . $row['cityName'] . '">Send Request Again</button>';
                echo '</li>';
            }
            

            echo '</ul>';

            // Add the 'Clear History' button here
            echo '<button class="clear-history-btn">Clear History</button>';

        }
        ?>
    </div>
</section>




<section id="complaint" class="complaint">
    <div class="container">
        <h1 style="color: white;">Complaint</h1>
        <form method="post" action="">
            <select name="complaint_about" required>
              <option value="">select complaint about</option>
                <option value="service">Service</option>
                <option value="provider">Service Provider</option>
                <option value="other">Other</option>
            </select><br>
            <textarea name="description" rows="4" cols="50" placeholder="Add description about complaint" required></textarea><br>

            <button type="submit" class="submitBtn" onclick="submitComplaint()">Submit Complaint</button>
            <button type="button" class="cancelButton" onclick="cancelComplaint()">Clear</button>
        </form>
        <?php
include 'db_connection.php';
function submitComplaint($userId, $complaintAbout, $description) {
    global $conn;
    $checkQuery = "SELECT COUNT(*) FROM complaints WHERE user_id = ? AND complaint_about = ? AND description = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("iss", $userId, $complaintAbout, $description);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();
    if ($count > 0) {
        return false; 
    }
    $insertQuery = "INSERT INTO complaints (user_id, complaint_about, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iss", $userId, $complaintAbout, $description);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        return false;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["complaint_about"], $_POST["description"])) {
        $complaintAbout = $_POST["complaint_about"];
        $description = $_POST["description"];

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
        $stmtUserId = $conn->prepare($userIdQuery);
        $stmtUserId->bind_param("s", $userEmail); 
        $stmtUserId->execute();
        $stmtUserId->bind_result($userId);
        $stmtUserId->fetch();
        $stmtUserId->close();

        if (submitComplaint($userId, $complaintAbout, $description)) {
            
        } 
    }
}
$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<section id="complaint" class="complaint">';
    echo '<div class="container">';
    echo '<h1 style="color: white;">Complaint Response</h1>';

    while ($row = $result->fetch_assoc()) {
        // Display admin response if available
        if (!empty($row['response'])) {
            echo '<p> ' . $row['response'] . '</p>';
        } else {
            echo '<p></p>';
        }

        echo '</div>';
    }
    echo '</div>';
    echo '</section>';
} else {
    echo '<section id="complaint" class="complaint">';
    echo '<div class="container">';
    echo '<h1 style="color: white;">Complaint Response</h1>';
    echo '<p>No complaints available.</p>';
    echo '</div>';
    echo '</section>';
}
?>
</div>
</section>

    </div>
  

<script>
    function cancelComplaint() {
       
        alert("Complaint canceled!");
    }
    function submitComplaint(){
    alert("Complaint submitted successfully");
    }
</script>

  
  
  
      </div>
   <script src="user_dash.js"></script>
    <script>
 function sendRequest(providerName) {
  function sendRequest(providerName) {
    var selectedProviderId = $('#selectedProviderId').val();
    console.log('Selected Provider ID: ' + selectedProviderId);
    
    
    alert('Request sent successfully for ' + providerName);
}}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>  




</script>
<script src="requestSend.js"></script>





<script>
document.addEventListener('DOMContentLoaded', function() {
    const clearHistoryBtn = document.querySelector('.clear-history-btn');
    
  
    clearHistoryBtn.addEventListener('click', function() {
        
        localStorage.removeItem('history');
        console.log('History cleared from local storage.');
    });
});
</script>


</script>
</body>
</html>