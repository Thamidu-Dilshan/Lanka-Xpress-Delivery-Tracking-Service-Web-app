<?php
    session_start();
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanka Xpress Delivery Service</title>
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="home.css">
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
                    <div class="auth-buttons">
                    <?php if (isset($_SESSION['user'])  ) { ?>
            <li><a href="logout.php" class="login-btn" >Logout</a></li>
        <?php } else { ?>
          <li><a href="userlogin.php" class="login-btn" >Login</a></li>
        <?php } ?>

          <?php if (isset($_SESSION['user'])  ) { ?>
            <a href="" class="register-btn"> Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</a>
            
        <?php } else { ?>
          <li><a href="signup.html" class="register-btn">Sign Up</a></li>
        <?php } ?>

                </ul>
            </nav>
        </div>
    </header>
    
    <section class="hero">
        <div class="container">
            <h1>Speed, Accuracy and Core</h1>
            <p>Your reliable courier service partner in Sri Lanka</p>
            <a href="signup.html" class="btn">Track Your Package</a>
        </div>
    </section>
    
    <section class="about">
        <div class="container">
            <h2>Welcome to Lanka Xpress</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>The Company was established in 2015 and is backed by an experienced management team and staff where the experience is in the range 10 to 30 years in the courier business.</p>
                    <p>The Company was incorporated to address the vacuum in the market in providing efficient, effective and customer friendly courier service to public and private sector organizations and individuals across the island.</p>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Prompt Xpress Team">
                </div>
            </div>
        </div>
    </section>
    
<footer class="footer" >
        <div class="footer-main">
          <div class="footer-section programs" style="margin-left: 100px;">
            <h3>Navigation</h3>
            <ul>
              <li><a href="home.php">Home</a></li>
              <li><a href="aboutus.php">About Us</a></li>
              <li><a href="branch.php">Branch Network</a></li>
              <li><a href="">Contact Us</a></li>
              <li><a href="">Track Your Item</a></li>
            </ul>
          </div>
      
          <div class="footer-section contact" style="margin-right: 100px;margin-top: 50px;">
            <h3>Contact Us</h3>
            <p>📞 +94 112 123 456</p>
            <p>✉️ <a href="mailto:info@fitzone.com">info@lankaxpress@gmail.com</a></p>
            <p>📍 No 50, Galle Rd, Colombo 6,Sri Lanka </p>
          </div>
        </div>
      
        <div class="footer-bottom">
          <div class="footer-logo" >
            <a href="home.php">
              <img src="images/Lanka.png" alt="footer logos" style="width: 100px; height: auto; margin-left: 50px;">
              
            </a>
            

           <div style=" margin-left: 340px;">
            <div class="footer-copy">
              <p>© 2025 Lanka Xpress Delivery Service. All rights reserved.</p>
            </div>
        
            <div class="footer-social" >
              <span>Follow us</span>
              <div class="social-icons">
                <img src="images/facebook icon.jpeg" alt="social-icons" class="icons">
                <img src="images/insta.jpeg" alt="social-icons" class="icons">
                <img src="images/whatsapp logo.jpeg" alt="social-icons" class="icons">
              </div>
            </div>
            

           </div>
          </div>
          </div>
    

      
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
      </footer>
</body>
</html>