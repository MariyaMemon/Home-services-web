<?php
session_start();
include('db_connection.php');
if (isset($_SESSION['admin_data'])) {
    $admin_data = $_SESSION['admin_data'];
} 
$adminName = $_SESSION['admin_data']['admin_name'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
     function signOut(){
     window.location.assign("Home.php");        
       } 
</script>
    <script defer>
        function showSection(sectionId) {
            console.log("Show section is called")
            var sections = document.querySelectorAll('.table-section');
            sections.forEach(function(section) {
                section.style.display = 'none';
            });
            var selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
        }
        
       
    </script>

    <link rel="stylesheet" href="Admin.css">

    <style>

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 10px;
            background-color: #fff;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: #fff;
        }

        table tbody tr:hover {
            background-color: #f5f5f5;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media (max-width: 768px) {
            table {
                width: 100%;
            }
        }
        .users-list {
            height: 80vh;
            overflow-y: auto;
        }

        .dashboard-cards {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .dashboard-card {
            width: 25%;
            flex: 0 1 auto !important;
            height: 200px;
            border-radius: 8px;
            overflow: hidden;
            margin: 7px 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card:hover {
            transform: scale(1) !important;
        }

        .table-section {
            display: none;
        }


        .view-button {
            padding: 6px 12px !important;
            cursor: pointer !important;
            border-radius: 8px !important;
            outline: none !important;
            border: none !important;
            transition: transform 0.1s ease !important;
        }

        .view-button:hover {
            transform: scale(1.05) !important;
        }

        .provider-profile {
    position: relative;
    display: flex;
    align-items: center;
}
.provider-profile img {
    width: 50px;
     height: 50px;
    
}
.provider-profile {
 border:none;
    overflow: hidden;  
}
    </style>

</head>


<body>
    <div class="sidebar" id="sidebar">
        <a href="#dashboard">
            <i class="bx bx-home"></i>
            <span>Dashboard</span>
        </a>

        <a href="#requests">
            <i class="bx bx-list-check"></i>
            <span>Requests</span>
        </a>

        <a href="#services">
            <i class="bx bx-wrench"></i>
            <span>Services</span>
        </a>

        <a href="#complaints">
            <i class="bx bx-message-detail"></i>
            <span>Complaints</span>
        </a>
        <a href="#account">
            <i class="bx bx-user"></i>
            <span>Account Setting</span>
        </a>
        <a href="#" onclick="signOut()">
            <i class="bx bx-log-out"></i>
            <span>Logout</span>
        </a>
    </div>
    <div class="content" id="content">


    <section id="account" class="account">
            <div class="container">
                <h1>Account Settings</h1>
<?php

?>  
               <form action="" method="POST" enctype="multipart/form-data" >
               <div class="profile-container">
        <div class="profile-picture" id="profile-picture-container">
            <?php
                
                if (isset( $_SESSION['admin_data']['profile_picture'])) {
                    echo '<img src="' . $_SESSION['admin_data']['profile_picture'] . '" alt="">';
                } else {
                    echo '<img src="default-person-icon.png" alt="Default Icon">';
                }
            ?>
            <input type="file" name="upload_picture" id="upload_picture" class="upload-input" onchange="updateProfilePicture(this)">
            <div id="file-name"></div>
        </div>
            </div>                                       
            
                    <input type="text" id="email_contact" name="email_contact" value="<?php echo !empty($admin_data['email']) ? $admin_data['email'] : $admin_data['contact']; ?>" 
                     <?php echo (!empty($admin_data['email']) ? 'readonly' : ''); ?> disabled >                        
                    <input type="text" id="address" name="address" placeholder="Enter your Address"  >                    
                    <input type="password" id="passwod" name="new_passwod" placeholder="update password"  >
                     <input type="submit" id="save_changes" value="Save Changes" >
                </form>
        </section>
        <!-- Inside the <div class="container"> of the dashboard section-->

        <section id="complaints" class="dashboard" style="height: 300vh;">
            <div class="dashboard-cards">



                <div class="dashboard-card green ">
                    <div class="card-header">Total Complaints</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $totalComplaintsQuery = "SELECT COUNT(*) AS total_complaints FROM complaints";
                        $complaintsCountQuery = $conn->query($totalComplaintsQuery);
                        $complaints = ($complaintsCountQuery->num_rows > 0) ? $complaintsCountQuery->fetch_assoc()['total_complaints'] : 0;
                        ?>
                        <h2><?php echo $complaints; ?></h2>
                        <button onclick="showSection('totalComplaints')" class="view-button">View</button>
                    </div>
                </div>
                <div class="dashboard-card blue">
                    <div class="card-header">Pending Complaints</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $pendingComplaintsQuery = "SELECT COUNT(*) AS pending_complaints FROM complaints WHERE response IS NULL";
                        $complaintsCountQuery = $conn->query($pendingComplaintsQuery);
                        $complaints = ($complaintsCountQuery->num_rows > 0) ? $complaintsCountQuery->fetch_assoc()['pending_complaints'] : 0;
                        ?>
                        <h2><?php echo $complaints; ?></h2>
                        <button onclick="showSection('pendingComplaints')" class="view-button">View</button>
                    </div>
                </div>

                <div class="dashboard-card red">
                    <div class="card-header">Responded Complaints</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $respondedComplaintsQuery = "SELECT COUNT(*) AS responded_complaints FROM complaints WHERE response IS NOT NULL";
                        $complaintsCountQuery = $conn->query($respondedComplaintsQuery);
                        $complaints = ($complaintsCountQuery->num_rows > 0) ? $complaintsCountQuery->fetch_assoc()['responded_complaints'] : 0;
                        ?>
                        <h2><?php echo $complaints; ?></h2>
                        <button onclick="showSection('respondedComplaints')" class="view-button">View</button>
                    </div>
                </div>
            </div>

            <section id="totalComplaints" class="table-section users">
                <div class="container" style="padding: 10px 15px;">
                    <h1>Total Complaints</h1>
                    <div class="users-list">
                        <?php

                        $sql = "SELECT complaint_id, user_id, providers_id, description, response FROM complaints";
                        $result = $conn->query($sql);

                        echo '
                                <table style="background-color: white;">
                                    <thead>
                                        <tr>
                                            <th>Complaint ID</th>
                                            <th>User Id</th>
                                            <th>Providers Id</th>
                                            <th>Description</th>
                                            <th>Response</th>

                                        </tr>
                                    </thead>
                                    <tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["complaint_id"] . '</td>';
                            echo '<td>' . $row["user_id"] . '</td>';
                            echo '<td>' . $row["providers_id"] . '</td>';
                            echo '<td>' . $row["description"] . '</td>';
                            // echo '<td>' . $row["response"] . '</td>';
                            echo '<td> <button  >response</button> </td>';
                            echo '</tr>';
                        }

                        echo '</tbody>
                                    </table>';

                        ?>
                    </div>

                </div>
               <div class="responseModal">
                   <input type="text" class="responseBox">
               </div>
            </section>

            <section id="pendingComplaints" class="table-section users">
                <div class="container" style="padding: 10px 15px;">
                    <h1>Pending Complaints</h1>
                    <div class="users-list">
                        <?php

                        $sql = "SELECT complaint_id, user_id, providers_id, description FROM complaints WHERE response IS NULL";
                        $result = $conn->query($sql);

                        echo '
                                <table style="background-color: white;">
                                    <thead>
                                        <tr>
                                            <th>Complaint ID</th>
                                            <th>User Id</th>
                                            <th>Providers Id</th>
                                            <th>Description</th>

                                        </tr>
                                    </thead>
                                    <tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["complaint_id"] . '</td>';
                            echo '<td>' . $row["user_id"] . '</td>';
                            echo '<td>' . $row["providers_id"] . '</td>';
                            echo '<td>' . $row["description"] . '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>
                                        </table>';

                        ?>
                    </div>

                </div>

            </section>


            <section id="respondedComplaints" class="table-section users">
                <div class="container" style="padding: 10px 15px;">
                    <h1>Responded Complaints</h1>
                    <div class="users-list">
                        <?php

                        $sql = "SELECT complaint_id, user_id, providers_id, description FROM complaints WHERE response IS NOT NULL";
                        $result = $conn->query($sql);

                        echo '
                            <table style="background-color: white;">
                                <thead>
                                    <tr>
                                        <th>Complaint ID</th>
                                        <th>User Id</th>
                                        <th>Providers Id</th>
                                        <th>Description</th>

                                    </tr>
                                </thead>
                                <tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["complaint_id"] . '</td>';
                            echo '<td>' . $row["user_id"] . '</td>';
                            echo '<td>' . $row["providers_id"] . '</td>';
                            echo '<td>' . $row["description"] . '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>
                                </table>';

                        ?>
                    </div>

                </div>

            </section>
        </section>

        <section id="services" class="dashboard">
            <div class="dashboard-cards">



                <div class="dashboard-card green ">
                    <div class="card-header">Total Services</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $servicesCountQuery = "SELECT COUNT(*) AS total_services FROM `services`";
                        $servicesCountResult = $conn->query($servicesCountQuery);
                        $servicesCount = ($servicesCountResult->num_rows > 0) ? $servicesCountResult->fetch_assoc()['total_services'] : 0;
                        ?>
                        <h2><?php echo $servicesCount; ?></h2>
                        <button onclick="showSection('totalServices')" class="view-button">View</button>
                    </div>
                </div>
                <div class="dashboard-card blue">
                    <div class="card-header">Service Providers</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $providerCountQuery = "SELECT COUNT(*) AS provider_count FROM provider";
                        $providerCountResult = $conn->query($providerCountQuery);
                        $providerCount = ($providerCountResult->num_rows > 0) ? $providerCountResult->fetch_assoc()['provider_count'] : 0;
                        ?>
                        <h2><?php echo $providerCount; ?></h2>
                        <button onclick="showSection('provider')" class="view-button">View</button>
                    </div>
                </div>

                <div class="dashboard-card red">
                    <div class="card-header">Services Area</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $distinctCityCountQuery = "SELECT COUNT(DISTINCT cityName) AS distinct_city_count FROM provider_services";
                        $distinctCityCountResult = $conn->query($distinctCityCountQuery);
                        $distinctCityCount = ($distinctCityCountResult->num_rows > 0) ? $distinctCityCountResult->fetch_assoc()['distinct_city_count'] : 0;
                        ?>
                        <h2><?php echo $distinctCityCount; ?></h2>
                        <button onclick="showSection('serviceArea')" class="view-button">View</button>
                    </div>
                </div>
            </div>
            <section id="provider" class="table-section provider">
                <div class="container" style="padding: 10px 15px;">
                    <h1 style="color: black;">Total Providers</h1>
                    <div class="users-list">
                        <table style="background-color:white;">
                            <thead>
                                <tr>
                                    <th>Provider ID</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <!-- <th>Contact</th> -->
                                    <th>city </th>
                                    <th>service</th>
                                    <th>Profile Picture</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
// Fetch provider data
$sql = "SELECT p.providers_id, p.user_name,p.email,p.contact, p.profile_picture, ps.cityName, s.service_name
        FROM provider_services ps
        INNER JOIN provider p ON ps.providers_id = p.providers_id
        INNER JOIN services s ON ps.service_id = s.service_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["providers_id"] . '</td>'; // Corrected column name
        echo '<td>' . $row["user_name"] . '</td>'; // Corrected column name
       echo '<td>';
        if ($row["email"] !== null) {
            echo $row["email"];
            if ($row["contact"] !== null) {
                echo ' ' . $row["contact"];
            }
        } elseif ($row["contact"] !== null) {
            echo $row["contact"];
        } else {
            echo "null";
        }
        echo '</td>';
        echo '<td>' . $row["cityName"] . '</td>';
        echo '<td>' . $row["service_name"] . '</td>';
        // Assuming profile_picture is not available in this query result
        echo '<td>';
        
        echo '<div class="provider-profile">';
        if (!empty($row['profile_picture'])) {
            echo '<img src="' . $row['profile_picture'] . '" alt="">';
        } else {
            echo '<img src="default-person-icon.png" alt="">';
        }
        echo '</div>';
   echo '</td>';
        // echo '<td><img src="default-profile-picture.jpg" alt="Profile Picture" style="width: 50px; height: 50px;"></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">No providers found</td></tr>';
}
?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section id="totalServices" class="table-section totalServices">
                <div class="container" style="padding: 10px 15px;">
                    <h1 style="color: black;">Total Services</h1>
                    <div class="users-list">
                        <table style="background-color:white;">
                            <thead>
                                <tr>
                                    <th>Service ID</th>
                                    <th>Service Name</th>
                                    <th>delete services</th>

                                </tr>
                            </thead>
                            <tbody>
                                
                                
                                <?php



                                // Fetch provider data
                                $sql = "SELECT service_id, service_name FROM services";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["service_id"] . '</td>';
                                        echo '<td>' . $row["service_name"] . '</td>';

                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="8">No Services found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- <button id="addServiceBtn">Add New Service</button> -->
                    </div>
                </div>
                <div id="addServiceModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Service</h2>
        <!-- Add form elements for adding a new service -->
    </div>
</div>
            </section>

            <section id="serviceArea" class="table-section totalServices">
                <div class="container" style="padding: 10px 15px;">
                    <h1 style="color: black;">Services Area</h1>
                    <div class="users-list">
                        <table style="background-color:white;">
                            <thead>
                                <tr>
                                    <th>City Name</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php



                                // Fetch provider data
                                $sql = "SELECT DISTINCT cityName FROM provider_services WHERE cityName IS NOT NULL";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["cityName"] . '</td>';

                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="8">No Area Available</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </section>



        <section id="requests" class="dashboard" style="height: 300vh;">
            <div class="dashboard-cards">



                <div class="dashboard-card green ">
                    <div class="card-header">Completed Requests</div>
                    <div class="card-body">
                    <?php
    // Fetch and display the count of accepted service requests
    $requestCountQuery = "SELECT COUNT(*) AS request_count FROM `service request` WHERE `status` = 'accepted'";
    $requestCountResult = $conn->query($requestCountQuery);
    $requestCount = ($requestCountResult->num_rows > 0) ? $requestCountResult->fetch_assoc()['request_count'] : 0;
?>

                        <h2><?php echo $requestCount; ?></h2>
                           
                            <button class="view-button" onclick="showSection('completeRequests')">View</button>
                    </div>
                    
                </div>
                
                <div class="dashboard-card blue ">
                    <div class="card-header">Rejected Requests</div>
                    <div class="card-body">
                    <?php
    // Fetch and display the count of rejected service requests
    $requestCountQuery = "SELECT COUNT(*) AS request_count FROM `service request` WHERE `status` = 'rejected'";
    $requestCountResult = $conn->query($requestCountQuery);
    $requestCount = ($requestCountResult->num_rows > 0) ? $requestCountResult->fetch_assoc()['request_count'] : 0;
?>

                        <h2><?php echo $requestCount; ?></h2>
                        <button class="view-button" onclick="showSection('rejectedRequests')">View</button>
                    </div>
                </div>
                <div class="dashboard-card red">
                    <div class="card-header">Pending Requests</div>
                    <div class="card-body">
                    <?php
    // Fetch and display the count of service requests with null status
    $requestCountQuery = "SELECT COUNT(*) AS request_count FROM `service request` WHERE `status` IS NULL";
    $requestCountResult = $conn->query($requestCountQuery);
    $requestCount = ($requestCountResult->num_rows > 0) ? $requestCountResult->fetch_assoc()['request_count'] : 0;
?>

                        <h2><?php echo $requestCount; ?></h2>
                        <button class="view-button" onclick="showSection('pendingRequests')">View</button>
                    </div>
                </div>

            </div>
            <section id="completeRequests" class="requests table-section" style="display: none;">
        <div class="container" style="padding: 10px 15px;">
                <h1 style="color: white;">Completed Requests</h1>
                <div class="users-list">
                    <table style="background-color:white;">
                        <thead>
                            <tr>
                                <th>Req ID</th>
                                <th>user ID</th>
                                <th>Service ID</th>
                                <th>Time/Dates</th>

                                <th>Provider ID</th>
                                <th>Description</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>

                        <?php
    $sql = "SELECT request_id, user_id, service_id, `time_dates`, providers_id, description, status  FROM `service request` WHERE status = 'accepted' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["request_id"] . '</td>';
            echo '<td>' . $row["user_id"] . '</td>';
            echo '<td>' . $row["service_id"] . '</td>';
            echo '<td>' . $row["time_dates"] . '</td>';
            echo '<td>' . $row["providers_id"] . '</td>';
            echo '<td>' . $row["description"] . '</td>';
            echo '<td>' . $row["status"] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="8">No requests found</td></tr>';
    }
?>

                        </tbody>
                    </table>

                </div>

            </div>

        </section>
        <section id="pendingRequests" class="requests table-section" style="display: none;">
            <div class="container" style="padding: 25px 15px;">
                <h1 style="color: white;">Pending Requests</h1>
                <div class="users-list">
                    <table style="background-color:white;">
                        <thead>
                            <tr>
                                <th>Req ID</th>
                                <th>user ID</th>
                                <th>Service ID</th>
                                <th>Time/Dates</th>

                                <th>Provider ID</th>
                                <th>Description</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT request_id, user_id, service_id, `time_dates`, providers_id, description, status FROM `service request` WHERE status IS NULL";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row["request_id"] . '</td>';
                                    echo '<td>' . $row["user_id"] . '</td>';
                                    echo '<td>' . $row["service_id"] . '</td>';
                                    echo '<td>' . $row["time_dates"] . '</td>';
                                    echo '<td>' . $row["providers_id"] . '</td>';
                                    echo '<td>' . $row["description"] . '</td>';
                                    echo '<td>' . $row["status"] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="8">No requests found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </section>

        <section id="rejectedRequests" class="requests table-section" style="display: none;">
            <div class="container" style="padding: 25px 15px;">
                <h1 style="color: white;">Rejected Requests</h1>
                <div class="users-list">
                    <table style="background-color:white;">
                        <thead>
                            <tr>
                                <th>Req ID</th>
                                <th>user ID</th>
                                <th>Service ID</th>
                                <th>Time/Dates</th>

                                <th>Provider ID</th>
                                <th>Description</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT request_id, user_id, service_id, `time_dates`, providers_id, description, status FROM `service request` WHERE status = 'rejected' ";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row["request_id"] . '</td>';
                                    echo '<td>' . $row["user_id"] . '</td>';
                                    echo '<td>' . $row["service_id"] . '</td>';
                                    echo '<td>' . $row["time_dates"] . '</td>';
                                    echo '<td>' . $row["providers_id"] . '</td>';
                                    echo '<td>' . $row["description"] . '</td>';
                                    echo '<td>' . $row["status"] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="8">No requests found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </section>
        </section>
       


        <section id="dashboard" class="dashboard">
            <div class="dashboard-cards">
                <div class="dashboard-card red">
                    <div class="card-header">Total Service Users</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of registered users
                        $userCountQuery = "SELECT COUNT(*) AS user_count FROM users";
                        $userCountResult = $conn->query($userCountQuery);
                        $userCount = ($userCountResult->num_rows > 0) ? $userCountResult->fetch_assoc()['user_count'] : 0;
                        ?>
                        <h2><?php echo $userCount; ?></h2>
                        <button onclick="showSection('totalServiceUsers')" class="view-button">View</button>

                    </div>
                </div>
                <div class="dashboard-card blue">
                    <div class="card-header">Total Providers</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $providerCountQuery = "SELECT COUNT(*) AS provider_count FROM provider";
                        $providerCountResult = $conn->query($providerCountQuery);
                        $providerCount = ($providerCountResult->num_rows > 0) ? $providerCountResult->fetch_assoc()['provider_count'] : 0;
                        ?>
                        <h2><?php echo $providerCount; ?></h2>
                        <button onclick="showSection('providerMain')" class="view-button">View</button>
                    </div>
                </div>
                <div class="dashboard-card green">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <?php
                        // Fetch and display the count of providers
                        $userCountQuery = "SELECT COUNT(*) AS user_count FROM users";
                        $userCountResult = $conn->query($userCountQuery);
                        $userCount = ($userCountResult->num_rows > 0) ? $userCountResult->fetch_assoc()['user_count'] : 0;
                        $providerCountQuery = "SELECT COUNT(*) AS provider_count FROM provider";
                        $providerCountResult = $conn->query($providerCountQuery);
                        $providerCount = ($providerCountResult->num_rows > 0) ? $providerCountResult->fetch_assoc()['provider_count'] : 0;
                        ?>
                        <h2><?php echo $providerCount + $userCount; ?></h2>

                    </div>
                </div>


            </div>
            <section id="totalServiceUsers" class="table-section users">
                <div class="container" style="padding: 10px 15px;">
                    <h1>Total Service Users</h1>
                    <div class="users-list">
                        <?php

                        $sql = "SELECT user_id, user_name, email, contact, registration_date FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo '
        <table style="background-color: white;">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email/Contact</th>
                    <th>Registartion date</th>
                </tr>
            </thead>
            <tbody>';

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row["user_id"] . '</td>';
                                echo '<td>' . $row["user_name"] . '</td>';

                                $displayEmailContact = ($row["email"] !== null ? $row["email"] : '') . ($row["contact"] !== null ? $row["contact"] : 'Contact');
                                echo '<td>' . ($displayEmailContact !== '' ? $displayEmailContact : 'Contact') . '</td>';
                                echo '<td>' . $row["registration_date"] . '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody>
        </table>';
                        }
                        ?>
                    </div>

                </div>

            </section>

            <section id="providerMain" class="table-section provider">
                <div class="container" style="padding: 10px 15px;">
                    <h1 style="color: black;">Total Providers</h1>
                    <div class="users-list">
                        <table style="background-color:white;">
                            <thead>
                                <tr>
                                    <th>Provider ID</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Registration Date</th>
                                    <th>Address</th>
                                    <th>Profile Picture</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php



                                // Fetch provider data
                                $sql = "SELECT providers_id, user_name, email, contact, registration_date, address, profile_picture FROM provider";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["providers_id"] . '</td>';
                                        echo '<td>' . $row["user_name"] . '</td>';
                                        echo '<td>' . ($row["email"] !== null ? $row["email"] : "null") . '</td>';
                                        echo '<td>' . ($row["contact"] ? $row["contact"] : "null") . '</td>';
                                        echo '<td>' . $row["registration_date"] . '</td>';
                                        echo '<td>' . $row["address"] . '</td>';
                                        echo '<td><img src="' . $row["profile_picture"] . '" alt="Profile Picture" style="width: 50px; height: 50px;"></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="8">No providers found</td></tr>';
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </section>


        <section id="totalUsers" class="users" style="height: 300vh;">
            <div class="container" style="padding: 25px 15px;">
                <h1 style="color: white;">Total Users Registered</h1>
                <div class="users-list">
                    <?php

                    $sql = "SELECT user_id, user_name, email, contact, registration_date FROM users";
                    $result = $conn->query($sql);

                    $providerQuery = "SELECT providers_id as user_id, user_name, email, contact, registration_date FROM provider";
                    $providerResult = $conn->query($providerQuery);

                    if ($result->num_rows > 0 || $providerResult->num_rows > 0) {
                        echo '
        <table style="background-color: white;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email/Contact</th>
                    <th>Registartion date</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["user_id"] . '</td>';
                            echo '<td>' . $row["user_name"] . '</td>';

                            $displayEmailContact = ($row["email"] !== null ? $row["email"] : '') . ($row["contact"] !== null ? $row["contact"] : 'Contact');
                            echo '<td>' . ($displayEmailContact !== '' ? $displayEmailContact : 'Contact') . '</td>';
                            echo '<td>' . $row["registration_date"] . '</td>';
                            echo '<td>User</td>';
                            echo '</tr>';
                        }

                        while ($row = $providerResult->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["user_id"] . '</td>';
                            echo '<td>' . $row["user_name"] . '</td>';

                            $displayEmailContact = ($row["email"] !== null ? $row["email"] : '') . ($row["contact"] !== null ? $row["contact"] : 'Contact');
                            echo '<td>' . ($displayEmailContact !== '' ? $displayEmailContact : 'Contact') . '</td>';
                            echo '<td>' . $row["registration_date"] . '</td>';
                            echo '<td>Provider</td>';

                            echo '</tr>';
                        }

                        echo '</tbody>
        </table>';
                    }
                    ?>
                </div>

            </div>

        </section>



        </section>
        <!-- complete requ -->
       

        

       

        <script src="./admin.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
<script>
     // Get the modal
 var modal = document.getElementById("addServiceModal");

// Get the button that opens the modal
var btn = document.getElementById("addServiceBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>

</html>