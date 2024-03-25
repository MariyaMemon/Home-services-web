<?php
session_start();

// Check if login errors exist in session
if (isset($_SESSION['login_errors']) && !empty($_SESSION['login_errors'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    foreach ($_SESSION['login_errors'] as $error) {
        echo $error . '<br>';
    }
    echo '</div>';

    // Clear the login errors from session
    unset($_SESSION['login_errors']);
}
?>

<?php
                    if (isset($_SESSION['registration_errors']) && !empty($_SESSION['registration_errors'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        foreach ($_SESSION['registration_errors'] as $error) {
                            echo $error . '<br>';
                        }
                        echo '</div>';

                        // Clear the registration errors from session
                        unset($_SESSION['registration_errors']);
                    }
                    ?>

<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>home</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" href="Home.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <!-- navigation bar -->
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
        <a href="services.php" style="--i:2;">Services</a>
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
             <a class="forget" href="forgetPas.php">forget password?</a>
            <input type="submit" id="login"   value="Login">   
            
            <a id="signup" href="#signupModal" style="color: black; transition: none;">Don't have an account?Signup</a>
            <!-- <a id="signup" href="#signupModal"><span style="color: black; transition:none;" ></span>Don't have an account? Signup</a> -->
          </form>
        </div>
      </div>           
      <div id="signupModal" class="modal">
        <div class="signupModal-content">
          <span class="closesignup" id="closeSignupbtn" > &times;</span>
          <h4 class="my-2" >Sign Up</h4>
          
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
        <input type="submit" id="Signup"   value="Signup">
        <!-- <a class="my-5" id="logIn" href="#loginModal"> <span style="color: black; transition:none; text-decoration: underline;" >Already have an account?</span>Login</a> -->
          </form>
        </div>
      </div> 
      
      
    </nav>
  </header>
     
   <div class="video-container my-1">
     <video autoplay loop muted width="100%"  >
      <!-- <img class="picc" src="picc.png" alt="" width="1255px" height="480px"> -->
       <source src="Video2.mp4" type="video/mp4">
      </video>
   </div>
   <section id="services">
   <div class="container my-5">
    <h2 style="text-align: center;" >Services We Provide</h2>
     <div class="container main text-center mt-5 text-transform:uppercase">
        <span>At <strong> Service گھر گھر </strong>, we are dedicated to providing you with convenient, 
          reliable, and high-quality home solutions. We strive to exceed your expectations 
          and build long-lasting relationships based on trust and exceptional service.
         Join us in transforming your home into a haven of comfort and functionality. 
         Let us handle the chores, repairs, and improvements, so you can make the most of your precious time at home.
         </span>
     </div>
   </div>
  </section>  
   
<div class="card-container">
<div class="card">
  <div class="image-container">
      <img src="plumb.jpg" alt="Image 1">
  </div>
  <div class="info">
      <p><h5>Plumbing</h5>
        Our skilled plumbers ensure your plumbing systems are in top-notch condition, addressing all your plumbing needs efficiently and effectively.</p>
  </div>
</div>
<div class="card">
  <div class="image-container">
      <img src="Cleaner.jpg" alt="Image 2">
  </div>
  <div class="info">
      <p><h5>Cleaning</h5>
        Our dedicated cleaning team is committed to providing thorough cleaning services, leaving your spaces spotless and refreshing your environment.</p>
  </div>
</div>
<div class="card">
  <div class="image-container">
      <img src="carpentry.jpeg" alt="Image 1">
  </div>
  <div class="info">
      <p><h5>Carpentry</h5> 
        Trust our experienced carpenters to craft, repair, and install furniture and woodwork that complements your home's style and functionality.</p>
  </div>
</div>
<div class="card">
  <div class="image-container">
      <img src="electric repair.jpg" alt="Image 2">
  </div>
  <div class="info">
      <p><h5>Electricity Repair</h5> 
        Count on us for safe and expert electrical repairs, ensuring your electrical systems function seamlessly and safely.</p>
  </div>
</div>
<div class="card">
  <div class="image-container">
      <img src="laundry.jpg" alt="Image 1">
  </div>
  <div class="info">
      <p><h5>laundry</h5>
        Take the hassle out of laundry with our laundry service. We handle your clothes with care, delivering clean and fresh garments to your doorstep.1</p>
  </div>
</div>
<div class="card">
  <div class="image-container">
      <img src="AC repair.jpg" alt="Image 2">
  </div>
  <div class="info">
      <p><h5>Electronics Repair</h5>
        Our proficient technicians specialize in diagnosing and repairing electronics, so you can enjoy a seamlessly functioning home.</p>
  </div>
</div>
</div>
  <!-- footer -->
  <div class="footer my-5">
    <footer class="footer my-5">
      <div class="container my-2">
          <div class="row">
              <div class="footer-col">
                  <h4>About us</h4>
                      <ul>
                      <br><li><p>Welcome to Service گھر گھر , your trusted
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
                        <br><a href="https://maps.app.goo.gl/q3H7eCHGkXapKwQq9"><i class="fas fa-map-marker-alt"></i>Street no 00,Hyderabad.</a>
                        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3604.5197620135177!2d68.36123392393007!3d25.38740677758899!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x394c70edcfb4eae5%3A0x4099a5c0cfc4e88d!2sThe%20Bombay%20Bakery!5e0!3m2!1sen!2s!4v1706462021054!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                        <br><a href="mailto:mariyamemon54@gmail.com"><i class="far fa-envelope"></i>  mariyamemon54@gmail.com</a>
                     <br><a href=""><i class="fas fa-phone-volume"></i>  +92 3473129630</a>
                  </ul>
                 </div>
              </div>
              <div class="footer-col">
                  <h4>Openings Hours</h4>
                 <br> <table  class="table footer-table">
                    <tbody>
                      <tr>
                        <td >Mon - Fri:</td>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script src="login.js"></script>
</body>
</html>

