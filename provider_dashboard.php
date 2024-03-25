<?php 
session_start();
include 'db_connection.php';
if (isset($_SESSION['provider_data'])) {
    $provider_data = $_SESSION['provider_data'];
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="provider.css">
    <link rel="stylesheet" href="user_reviews.css"> 
    <link rel="stylesheet" href="Appointment.css">
    <link rel="stylesheet" href="profile_provider.css">
    <link rel="stylesheet" href="complaint.css">
   
</head>
 <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
}

button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
 #servicesList {
    border-radius: 3px;
    padding: 10px;
    list-style: none;
}

#selectedServicesList li {
   background: linear-gradient(-40deg,rgb(248, 171, 4) 0.2%, white);
    background: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 5px;
    padding: 8px;
    display: flex;
    justify-content: space-between;
    text-transform: capitalize;
  font-family: 'Times New Roman', Times, serif;
  font-weight: 800;
    
}
.delete-button{
background-color: #ff6262;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 10px;
}
#selectedServicesList li button {
    background-color: #ff6262;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
} 
.charges{
    display:block;
    margin:10px;
    padding: 5px 10px;
}


/* Modal Styles */
.updateModal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.updateModal .modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}


    .star {
        color: #ccc; /* Default star color (empty) */
        font-size: 20px; /* Adjust the size as needed */
    }

    .filled {
        color: yellow; /* Filled star color */
    }

    .service-item {
    margin: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    list-style: none;
    position: relative;
}

/* Style for modal */


 </style>
<body>
    <div class="sidebar" id="sidebar">  
      
        <a href="#account">
            <i class="bx bx-user"></i>
            <span>Account Setting</span>
        </a>
        <a href="#services">
            <i class="bx bx-book-open"></i>
            <span>Add Services</span>
        </a>
        <a href="#appointments">
            <i class="bx bx-user-check"></i>
            <span>Appointments</span>
        </a>

        <a href="#appointmentHistory">
            <i class="bx bx-history"></i>
            <span>Appointment History</span>
        </a>

         <a href="#reviews">
            <i class="bx bx-star"></i>
            <span>Reviews</span>
        </a>
        <a href="#complaints">
            <i class="bx bx-error-alt"></i>
            <span>Complaints</span>
        </a>
        <a href="#" onclick="signOut()">
            <i class="bx bx-log-out"></i>
            <span>Logout</span>
        </a>
    </div>
   
    <div class="content" id="content">
<?php
include 'update_provider_info.php';
// include 'profile_upload.php';
// include 'profile_fetch.php';
?>  
        <section id="account" class="account">
            <div class="container">
                <h1>Account Settings</h1>
               <form action="" method="POST" enctype="multipart/form-data" >
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
                    <input type="text" id="name" name="user_name" value="<?php echo $provider_data['user_name'];?>" disabled>                  
                    <input type="text" id="email_contact" name="email_contact" value="<?php echo !empty($provider_data['email']) ? $provider_data['email'] : $provider_data['contact']; ?>" 
                     <?php echo (!empty($provider_data['email']) ? 'readonly' : ''); ?> disabled >                        
                    <input type="text" id="address" name="address" placeholder="Enter your Address" value="<?php echo $_SESSION['provider_data']['address']; ?>" >                    
                    <input type="password" id="passwod" name="new_passwod" placeholder="update password"  >
                     <input type="submit" id="save_changes" value="Save Changes" >
                </form>
        </section>
   


        <section id="services" class="services">     
       <br>
       <h2>Hi <?php echo $provider_data['user_name'] ?> Welcome to your Dashboard!</h2>
        <select id="servicesDropdown">
           <option value="">Select services which you are providing</option>
        </select>
       <select name="priceDropdown" id="priceDropdown" required>
        <option value="" id="">select charges</option>
        <option value="10$">10$</option>
        <option value="15$">15$</option>
        <option value="20$">20$</option>
        <option value="25$">25$</option>
        <option value="30$">30$</option>
        <option value="35$">35$</option>
        <option value="50$">50$</option>

       </select>
        <button id="addServiceButton">Add Service</button>
        <ul id="selectedServicesList"></ul>
        <ul id="submittedServicesList"></ul>
        

        <input type="text" class="cityName" name="cityName" id="cityName" placeholder="Add your city">
       

        <div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Update Service</h2>
        <label for="updatedService">Updated Service:</label>
        <input type="text" id="updatedService" name="updatedService" required>
        <label for="updatedPrice">Updated Price:</label>
        <input type="text" id="updatedPrice" name="updatedPrice" required>
        <button onclick="updateService()">Update</button>
    </div>
</div>

         <button id="submitButton">Submit</button>      
        </section>



        <section id="appointments" class="appointments" >
            <div class="container">
                <h1 style="color: white;">Appointment Requests</h1>
                <?php
include 'db_connection.php';


if (isset($_SESSION['provider_data']['email']) && !empty($_SESSION['provider_data']['email'])) {
    $providerEmail = $_SESSION['provider_data']['email'];
    $providerIdQuery = "SELECT providers_id FROM provider WHERE email = ?";
} elseif (isset($_SESSION['provider_data']['contact']) && !empty($_SESSION['provider_data']['contact'])) {
    $providerContact = $_SESSION['provider_data']['contact'];
    $providerIdQuery = "SELECT providers_id FROM provider WHERE contact = ?";
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid provider session.'));
    exit;
}

// Fetch provider ID from the database
$stmtProviderId = $conn->prepare($providerIdQuery);
$stmtProviderId->bind_param("s", $providerEmail); // Change this to $providerContact if needed
$stmtProviderId->execute();
$stmtProviderId->bind_result($providerId);
$stmtProviderId->fetch();
$stmtProviderId->close();

// Fetch appointment requests for the provider
$sql = "SELECT sr.*, u.user_name, s.service_name,u.profile_picture
        FROM `service request` sr
        JOIN users u ON sr.user_id = u.user_id
        JOIN services s ON sr.service_id = s.service_id
        WHERE sr.providers_id = ? AND sr.status IS NULL";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $providerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Display the list of appointment requests
    echo '<ul>';

    while ($row = $result->fetch_assoc()) {
        echo '<li>';
        echo '<div class="user-profile">';
        if (!empty($row['profile_picture'])) {
            echo '<img src="' . $row['profile_picture'] . '" alt="">';
        } else {
            echo '<img src="default-person-icon.png" alt="">';
        }
        echo '<h3> ' . $row['user_name'] . '</h3>';
        echo ' ' . $row['service_name'] . '<br>';
        echo ' ' . $row['time_dates'] . '<br>';
        echo ' ' . $row['description'] . '<br>';
        echo '</div>';
        echo '<button class="accept-appointment-btn" data-request-id="' . $row['request_id'] . '">Accept</button>';
        echo '<button class="reject-appointment-btn" data-request-id="' . $row['request_id'] . '">Reject</button>';
        echo '</li>';
    }

    echo '</ul>';
} else {
    echo '<p>No appointment requests available.</p>';
}

$stmt->close();
?>
             </div>
          </section>
        
        <br>
          <section id="appointmentHistory" class="appointmentHistory" style="overflow-y: auto; max-height: 520px;">
        <div class="container">
               <h1 style="color: white;">Appointment History</h1>
               <?php
    include 'db_connection.php';

    // Add checks for provider session here...
    if (isset($_SESSION['provider_data']['email']) && !empty($_SESSION['provider_data']['email'])) {
        $providerEmail = $_SESSION['provider_data']['email'];
        $providerIdQuery = "SELECT providers_id FROM provider WHERE email = ?";
    } elseif (isset($_SESSION['provider_data']['contact']) && !empty($_SESSION['provider_data']['contact'])) {
        $providerContact = $_SESSION['provider_data']['contact'];
        $providerIdQuery = "SELECT providers_id FROM provider WHERE contact = ?";
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid provider session.'));
        exit;
    }

   
    $stmtProviderId = $conn->prepare($providerIdQuery);
    $stmtProviderId->bind_param("s", $providerEmail); 
    $stmtProviderId->execute();
    $stmtProviderId->bind_result($providerId);
    $stmtProviderId->fetch();
    $stmtProviderId->close();

    $sql = "SELECT sr.*, u.user_name, s.service_name, u.profile_picture
            FROM `service request` sr
            JOIN users u ON sr.user_id = u.user_id
            JOIN services s ON sr.service_id = s.service_id
            WHERE sr.providers_id = ? AND sr.status = 'accepted'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $providerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display the list of appointment history
        echo '<ul>';

        while ($row = $result->fetch_assoc()) {
            echo '<li>';
            echo '<div class="user-profile">';
            if (!empty($row['profile_picture'])) {
                echo '<img src="' . $row['profile_picture'] . '" alt="">';
            } else {
                echo '<img src="default-person-icon.png" alt="">';
            }
            echo '<h3>User: ' . $row['user_name'] . '</h3>';
            echo 'Service: ' . $row['service_name'] . '<br>';
            echo 'Date: ' . $row['time_dates'] . '<br>';
            echo 'Description: ' . $row['description'] . '<br>';
            echo '</div>';
            echo '</li>';
        }

        echo '</ul>';
   // Display the "Clear History" button when there are rows
   echo '<button id="clearHistoryBtn" class="clear-history-btn">Clear History</button>';
} else {
    echo '<p>No appointment history available.</p>';
}

    $stmt->close();
    ?>
            </div>
        </section>
<br>
        <section id="reviews" class="reviews">
    <div class="container">
        <h1 style="color: white;">Reviews</h1>

        <?php
        include 'db_connection.php';

        // Add checks for provider session here...
        if (isset($_SESSION['provider_data']['email']) && !empty($_SESSION['provider_data']['email'])) {
            $providerEmail = $_SESSION['provider_data']['email'];
            $providerIdQuery = "SELECT providers_id FROM provider WHERE email = ?";
        } elseif (isset($_SESSION['provider_data']['contact']) && !empty($_SESSION['provider_data']['contact'])) {
            $providerContact = $_SESSION['provider_data']['contact'];
            $providerIdQuery = "SELECT providers_id FROM provider WHERE contact = ?";
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid provider session.'));
            exit;
        }

        // Fetch provider ID from the database
        $stmtProviderId = $conn->prepare($providerIdQuery);
        $stmtProviderId->bind_param("s", $providerEmail); // Change this to $providerContact if needed
        $stmtProviderId->execute();
        $stmtProviderId->bind_result($providerId);
        $stmtProviderId->fetch();
        $stmtProviderId->close();

        // Fetch reviews for the provider
        $sql = "SELECT r.*, u.user_name, u.profile_picture
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                WHERE r.providers_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $providerId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Display the list of reviews
            echo '<ul>';

            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo '<div class="user-profile">';
                if (!empty($row['profile_picture'])) {
                    echo '<img src="' . $row['profile_picture'] . '" alt="">';
                } else {
                    echo '<img src="default-person-icon.png" alt="">';
                }
                echo '<h3> ' . $row['user_name'] . '</h3>';
                
                // Display stars based on the rating
                $rating = $row['rating'];
                echo '<div class="star-container">';
              
                for ($i = 1; $i <= 5; $i++) {
                    $starClass = ($i <= $rating) ? 'filled' : 'empty';
                    echo '<span class="star ' . $starClass . '">&#9733;</span>';
                }
                echo '</div>'; // Close star-container
                echo '<br>';

                echo ' ' . $row['review'] . '<br>';
                echo ' ' . $row['date/time'] . '<br>';
                echo '</div>';
                echo '</li>';
            }

            echo '</ul>';
        } else {
            echo '<p>No reviews available.</p>';
        }

        $stmt->close();
        ?>
    </div>
</section>



<section id="complaints" class="complaints">
    <div class="container">
        <h1 style="color: white;">Complaint</h1>
        <form method="post" action="">
            <select name="complaint_about" required>
                <option value="">Select complaint about</option>
                <option value="service">Service</option>
                <option value="provider">Service Provider</option>
                <option value="behavior">User Behavior</option>
                <option value="technical">Technical Issue</option>
                <option value="payment">Payment Issue</option>
                <option value="other">Other</option>
            </select><br>
            <textarea name="description" rows="4" cols="50" placeholder="Add description about complaint" required></textarea><br>

            <button type="submit" class="submitBtn" onclick="submitComplaint()">Submit Complaint</button>
            <button type="button" class="cancelButton" onclick="cancelComplaint()">Cancel</button>
        </form>

        <?php
        include 'db_connection.php';

        function submitComplaint($providerId, $complaintAbout, $description)
        {
            global $conn;
            $checkQuery = "SELECT COUNT(*) FROM complaints WHERE providers_id = ? AND complaint_about = ? AND description = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("iss", $providerId, $complaintAbout, $description);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();
            if ($count > 0) {
                return false;
            }
            $insertQuery = "INSERT INTO complaints (providers_id, complaint_about, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("iss", $providerId, $complaintAbout, $description);

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

                if (isset($_SESSION['provider_data']['email']) && !empty($_SESSION['provider_data']['email'])) {
                    $providerEmail = $_SESSION['provider_data']['email'];
                    $providerIdQuery = "SELECT providers_id FROM provider WHERE email = ?";
                } elseif (isset($_SESSION['provider_data']['contact']) && !empty($_SESSION['provider_data']['contact'])) {
                    $providerContact = $_SESSION['provider_data']['contact'];
                    $providerIdQuery = "SELECT providers_id FROM provider WHERE contact = ?";
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'Invalid provider session.'));
                    exit;
                }

                $stmtProviderId = $conn->prepare($providerIdQuery);
                $stmtProviderId->bind_param("s", $providerEmail);
                $stmtProviderId->execute();
                $stmtProviderId->bind_result($providerId);
                $stmtProviderId->fetch();
                $stmtProviderId->close();

                if (submitComplaint($providerId, $complaintAbout, $description)) {
                 
                }
            }
        }

        $sql = "SELECT * FROM complaints";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<section id="complaint" class="complaint">';
            echo '<div class="container">';
            echo '<h1 style="color: white;">Complaint</h1>';

            while ($row = $result->fetch_assoc()) {
                // Display admin response if available
                if (!empty($row['admin_response'])) {
                    echo '<p>Admin Response: ' . $row['admin_response'] . '</p>';
                } else {
                    echo '<p>No response yet.</p>';
                }

                echo '</div>';
            }
            echo '</div>';
            echo '</section>';
        } 
 else {
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
        // You can add any specific logic for canceling the complaint here
        alert("Complaint canceled!");
    }
    function submitComplaint(){
    alert("Complaint submitted successfully");
    }
</script>
     <script src="provider.js"></script>

    <script src="scriptting.js"></script>
    <script>
        function openModal(serviceId) {
    const updateModal = document.getElementById('updateModal');
    updateModal.style.display = 'block';

    // Fetch service details or populate form based on serviceId
    // You can use the serviceId to fetch the details and populate the update form
}

function closeModal() {
    const updateModal = document.getElementById('updateModal');
    updateModal.style.display = 'none';
}

    </script>
    <script src="appointmentStatus.js"></script>
</body>
</html>
