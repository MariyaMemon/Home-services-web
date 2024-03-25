<?php
include('db_connection.php');

?>
<!DOCTYPE html>
<html>

<head>
  <title>Home Service Availability</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <link rel="stylesheet" href="services.css">
  <link rel="stylesheet" href="Home.css">
  <link rel="stylesheet" href="footer.css">
  <style>
    body {
      margin: 0;
    }

    .select-styled-custom {
      color: #7d7d7d;
      width: 100%;
      height: 50px;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <header class="header">
    <a href="#" class="logo"> Service گھر گھر <i class="fas fa-tools"></i></a>
    <input type="checkbox" id="check">
    <label for="check" class="icons">
      <i class='bx bx-menu' id="menu-icon"></i>
      <i class='bx bx-x' id="close-icon"></i>
    </label>
    <nav class="navbar">
      <ul>
        <a class="active" href="Home.php" style="--i:0;">Home</a>
        <a href="aboout.php" style="--i:1;">About</a>
        <a class="active" href="service.php" style="--i:2;">Services</a>
        <a href="#contact" style="--i:3;">Contact</a>
        <a id="loginLink" href="" style="--i:4;">Login</a>
      </ul>
      <div id="loginModal" class="modal">
        <div class="modal-content">
          <span class="close" id="closeButton">&times;</span>
          <h4 class="heading mt-5">Login</h4>
          <form action="login3.php" method="post">
            <select name="select" id="">
              <option value="">Select type</option>
              <option value="user">service user</option>
              <option value="provider"> service provider</option>
            </select>
            <input type="text" name="email_contact" placeholder="Email or phone number" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required autocomplete="off">
            <a class="forget" href="">forget password?</a>
            <input type="submit" id="login" value="Login">
            <a id="signup" href="#signupModal"><span style="color: black; transition:none;">Don't have an account?</span>Sign Up</a>
          </form>
        </div>
      </div>
      <div id="signupModal" class="modal">
        <div class="signupModal-content">
          <span class="closesignup" id="closeSignupbtn"> &times;</span>
          <h4 class="my-2">Sign Up</h4>
          <form action="regis.php" method="POST">
            <input type="text" name="user_name" placeholder="Name" required autocomplete="off">
            <select name="select" id="">
              <option value="">Select type</option>
              <option value="user">service user</option>
              <option value="provider"> service provider</option>
            </select>
            <input type="text" id="emailOrPhone" name="email_contact" placeholder="Email or Phone number" required autocomplete="off">
            <span id="validationMessage"></span>
            <input type="password" name="password" placeholder="Password" required autocomplete="off">
            <input type="password" name="password" placeholder="Confirm Password" required>
            <input type="submit" id="Signup" value="Signup">
            <a class="my-5" id="logIn" href="#loginModal"> <span style="color: black; transition:none; text-decoration: underline;">Already have an account?</span>Login</a>
          </form>
        </div>
      </div>


    </nav>
  </header>

  <div class="my-header">
    <h1 class="main-heading">Find available services</h1>
    <div class="search-container">
      <select id="citySelect">
        <option value="">Any</option>
        <?php

$sql = "SELECT DISTINCT cityName FROM `provider_services` WHERE cityName IS NOT NULL AND cityName <> ''";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['cityName'] . "'>" . $row['cityName'] . "</option>";
    }
} 
        include 'getCities.php';
        // include 'getCities.php';
        ?>

      </select>
    </div>
  </div>
  <div id="results">
    <h2 class="heading">Services available in your searched city</h2>
    <ul id="serviceList">
      <!-- Results will be displayed here -->
    </ul>
  </div>

  <div class="card-container">

    <div class="card" data-title="Plumbing" data-description="Our skilled plumbers ensure your plumbing systems are in top-notch condition, addressing all your plumbing needs efficiently and effectively.">
      <h3>Plumbing</h3>
      <div class="image-container">
        <img src="plumb.jpg" alt="Image 1">
      </div>
      <div class="info">
        <p>Our skilled plumbers ensure your plumbing systems are in top-notch condition, addressing all your plumbing
          needs efficiently and effectively.</p>

      </div>
    </div>
    <div class="card" data-title="Cleaning">
      <h3>Cleaning</h3>
      <div class="image-container">
        <img src="Cleaner.jpg" alt="Image 2">
      </div>
      <div class="info">
        <p> Our dedicated cleaning team is committed to providing thorough cleaning services, leaving your spaces
          spotless and refreshing your environment..</p>

      </div>
    </div>
    <div class="card" data-title="Carpentry">
      <h3>Carpentry</h3>
      <div class="image-container">
        <img src="carpentry.jpeg" alt="Image 1">
      </div>
      <div class="info">
        <p>Trust our experienced carpenters to craft, repair, and install furniture and woodwork that complements your
          home's style and functionality.</p>

      </div>
    </div>
    <div class="card" data-title="Electricity Repair">
      <h3>Electricity Repair</h3>
      <div class="image-container">
        <img src="electric repair.jpg" alt="Image 1">
      </div>
      <div class="info">
        <p>Count on us for safe and expert electrical repairs, ensuring your electrical systems function seamlessly and
          safely.</p>

      </div>
    </div>
    <div class="card" data-title="Laundry">
      <h3>Laundry</h3>
      <div class="image-container">
        <img src="laundry.jpg" alt="Image 1">
      </div>
      <div class="info">
        <p>Take the hassle out of laundry with our laundry service. We handle your clothes with care, delivering clean
          and fresh garments to your doorstep.1</p>

      </div>
    </div>
    <div class="card" data-title="Electronics Repair">
      <div class="image-container">
        <h3>Electronics Repair</h3>
        <img src="AC repair.jpg" alt="Image 2">
      </div>
      <div class="info">
        <p>
          Our proficient technicians specialize in diagnosing and repairing electronics, so you can enjoy a seamlessly
          functioning home.</p>

      </div>
    </div>



  </div>

  <div class="popup-card" id="popup-card">
    <span class="close-popup" id="close-popup">&times;</span>
    <div class="image-container">
      <img src="plumb.jpg" alt="Image 1">
    </div>
    <h3 id="popup-title"></h3>
    <p id="popup-description"></p>
  </div>

  <div class="footer my-5">
    <footer class="footer my-5">
      <div class="container my-2">
        <div class="row">
          <div class="footer-col">
            <h4>About us</h4>
            <ul>
              <br>
              <li>
                <p>Welcome to Service گھر گھر , your trusted
                  solution for a range of household needs.
                  We pride ourselves on delivering reliable and
                  professional services to make your life easier and
                  your home more comfortable. <a href="aboout.php">learn more.</a></p>
              </li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Contact</h4>
            <div class="contact" id="contact">
              <ul>
                <br><a href="https://maps.google.com/"><i class="fas fa-map-marker-alt"></i>Street no 00,Hyderabad.</a>
                <br><a href="mailto:mariyamemon54@gmail.com"><i class="far fa-envelope"></i> mariyamemon54@gmail.com</a>
                <br><a href=""><i class="fas fa-phone-volume"></i> +92 3473129630</a>
              </ul>
            </div>
          </div>
          <div class="footer-col">
            <h4>Openings Hours</h4>
            <br>
            <table class="table">
              <tbody>
                <tr>
                  <td>Mon - Fri:</td>
                  <td>8am - 9pm</td>
                </tr>
                <tr>
                  <td>Sat - Sun:</td>
                  <td>8am - 1am</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="text-center p-2" style="background-color: rgba(0, 0, 0, 0.2);">

        <a href="https://facebook.com/"><i class="fab fa-facebook-square"></i></a>
        <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
        <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
        <a href="https://pk.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </footer>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      const cards = document.querySelectorAll('.card');
      const citySelect = $('#citySelect');
      const serviceList = $('#serviceList');

      citySelect.change(function() {
        const selectedCity = $(this).val();

        // Clear previous results
        serviceList.empty();

        console.log(selectedCity);
        if (selectedCity) {
          $.ajax({
            type: 'GET',
            url: 'getCities.php', 
            data: {
              city: selectedCity
            },
            success: function(data) {
              console.log(data);
              cards.forEach(card => {
                const title = card.getAttribute('data-title');
                console.log(title);
                if (data.includes(title)) {
                  console.log("Includes");
                  card.style.display = 'block';
                } else {
                  card.style.display = 'none';
                }
              });
            },
            error: function(error) {
              console.error('Error fetching data:', error);
            }
          });
        } else {
          cards.forEach(card => {
            card.style.display = 'block';
          });
        }
      });
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="login.js"></script>


</body>

</html>