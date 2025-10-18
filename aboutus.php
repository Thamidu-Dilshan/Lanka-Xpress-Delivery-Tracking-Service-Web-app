<?php
    session_start();
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lanka Xpress Delivery Service</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="aboutsus.css">
    <link rel="stylesheet" href="common.css" />
    <link rel="stylesheet" href="footer.css" />
</head>
<body>
<header>
    <div class="container">
      <div class="header-top">
        <div class="logo">Lanka <span>Xpress</span></div>
        <div class="phone">+94 112 123 456</div>
      </div>

      <nav>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="aboutus.php">About Us</a></li>
          <li><a href="branch.php">Branch Network</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="#">Track Your Item</a></li>
        </ul>

        <div class="auth-buttons">
          <?php if (isset($_SESSION['user'])) { ?>
            <a href="logout.php" class="login-btn">Logout</a>
            <a href="profile.php" class="register-btn">Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</a>
          <?php } else { ?>
            <a href="userlogin.php" class="login-btn">Login</a>
            <a href="registration.php" class="register-btn">Sign Up</a>
          <?php } ?>
        </div>
      </nav>
    </div>
  </header>

<section class="about-container">
  <!-- Left Side -->
  <div class="about-content">
    <p>
      At <strong>Lanka Xpress Delivery Service</strong>, we are passionate about making deliveries
      <strong>faster, safer, and more reliable</strong> for customers across Sri Lanka.
      We combine cutting-edge technology with a dedicated team to provide a seamless, stress-free delivery experience.
    </p>

    <p>
      Whether it’s a <strong>personal package</strong>, a <strong>time-sensitive document</strong>, or
      <strong>bulk business orders</strong>, we ensure every delivery is handled with precision, care, and speed.
      With <strong>island-wide coverage</strong> and real-time tracking, you stay connected every step of the way.
    </p>

    <div class="why-choose">
      <h2>Why Choose Us?</h2>
      <ul>
        <li><i class="ri-checkbox-circle-line"></i> Reliable & On-Time Service</li>
        <li><i class="ri-checkbox-circle-line"></i> Island-Wide Reach</li>
        <li><i class="ri-checkbox-circle-line"></i> Secure & Safe Handling</li>
        <li><i class="ri-checkbox-circle-line"></i> Affordable & Transparent Pricing</li>
        <li><i class="ri-checkbox-circle-line"></i> Dedicated Customer Support</li>
      </ul>
    </div>
  </div>

  <!-- Right Side -->
  <div class="about-image">
    <img src="images/Lanka Xpress Delivery in Action.png" alt="Lanka Xpress Truck">
  </div>
</section>

<footer class="footer">
    <div class="footer-main">
        <div class="footer-section programs" style="margin-left: 100px;">
            <h3>Navigation</h3>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="branch.php">Branch Network</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="#">Track Your Item</a></li>
            </ul>
        </div>

        <div class="footer-section contact" style="margin-right: 100px;margin-top: 50px;">
            <h3>Contact Us</h3>
            <p>📞 +94 112 123 456</p>
            <p>✉️ <a href="mailto:info@lankaxpress@gmail.com">info@lankaxpress@gmail.com</a></p>
            <p>📍 No 50, Galle Rd, Colombo 6, Sri Lanka</p>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-logo">
            <a href="home.php">
                <img src="images/Lanka.png" alt="footer logo" style="width: 100px; height: auto; margin-left: 50px;">
            </a>

            <div style="margin-left: 340px;">
                <div class="footer-copy">
                    <p>© 2025 Lanka Xpress Delivery Service. All rights reserved.</p>
                </div>

                <div class="footer-social">
                    <span>Follow us</span>
                    <div class="social-icons">
                        <img src="images/facebook icon.jpeg" alt="facebook" class="icons">
                        <img src="images/insta.jpeg" alt="instagram" class="icons">
                        <img src="images/whatsapp logo.jpeg" alt="whatsapp" class="icons">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</footer>

</body>
</html>
