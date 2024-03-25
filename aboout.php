<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>about</title>
  <link rel="stylesheet" href="about.css">
  <link rel="stylesheet" href="Home.css">
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
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
        <a class="active" href="aboout.php" style="--i:1;">about</a>
        <a href="serviceNEW.php" style="--i:2;">Services</a>
        <a href="#contact" style="--i:3;">Contact</a>
        <a id="loginLink" href="#" style="--i:4;">Login</a>
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
            <input type="submit" id="login"   value="Login">   
            <a id="signup" href="#signupModal"><span style="color: black; transition:none;" >Don't have an account?</span>Sign Up</a>
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
        <a class="my-5" id="logIn" href="#loginModal"> <span style="color: black; transition:none; text-decoration: underline;" >Already have an account?</span>Login</a>
          </form>
        </div>
      </div> 
    </nav>
  </header>
 
  <div class="container">
    <div class="box">
        <img src="worker.jpg" alt="Image 1" class="image">
        <div class="content">
            <h2></h2>
      
            <h1>About Our Service</h1>
            <p>Welcome to Service گھر گھر  - Your Trusted Home Services Provider!

              At Service گھر گھر , we take pride in making your life easier. We understand that maintaining your home can be a challenging and time-consuming task. That's why we're here to offer you a wide range of professional home services that cater to all your needs. Our mission is to provide top-quality services with a commitment to reliability, affordability, and customer satisfaction.</p>
        </div>
    </div>

    <div class="box">
      <div class="content">
       <h1>Our Team </h1> 
<p>
  At Service گھر گھر , we have a dedicated team of professionals who are committed to providing you with top-quality home services. Meet the experts behind our services:

  
  A detail-oriented professional who ensures that every service we provide meets our high standards of quality and reliability.
  
  Our team is here to make your life easier and your home better. We're dedicated to delivering exceptional service and ensuring your satisfaction with every job we undertake.
</p>
      </div>
      <img src="team.jpg" alt="Image 2" class="image">
    </div>

    

</div>
<div id="why-choose-us">
  <h2>Why Choose Us</h2>
  <div class="circle-box">
      <div class="circle">
         
          <p class="circle-content"> <h2>Quality</h2>We are committed to deliver the highest quality services to meet your needs.</p>
      </div> 
  </div>
  <div class="circle-box">
      <div class="circle">
          <p class="circle-content"><h2>Reliability</h2> You can count on us to be reliable and responsive, ensuring your satisfaction.</p>
      </div> 
  </div>

  <div class="circle-box">
      <div class="circle">
          <p class="circle-content"><h2>Affordability</h2> We offer competitive pricing to provide the best value for your money.</p>
      </div>
  </div>
</div>

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
                        your home more comfortable. <a href="aboout.html">learn more.</a></p>
                      </li>
                      </ul>
              </div>
              
            

              <div class="footer-col">
                  <h4>Contact</h4>
                  <div class="contact" id="contact">
                      <ul>
                        <br><a href="https://maps.google.com/"><i class="fas fa-map-marker-alt"></i>Street no 00,Hyderabad.</a>
                        <br><a href="mailto:mariyamemon54@gmail.com"><i class="far fa-envelope"></i>  mariyamemon54@gmail.com</a>
                     <br><a href=""><i class="fas fa-phone-volume"></i>  +92 3473129630</a>
                  </ul>
                 </div>
              </div>
              <div class="footer-col">
                  <h4>Openings Hours</h4>
                 <br> <table class="table">
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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script src="login.js"></script>
</body>

</html>