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
          <li><a href="my_parcels.php">Track Your Item</a></li>
          <li><a href="createparcel.php">Parcel Booking</a></li>
        
        

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
    
    <section class="hero">
        <div class="container">
            <h1>Speed, Accuracy and Core</h1>
            <p>Your reliable courier service partner in Sri Lanka</p>
            <a href="registration.php" class="btn">Track Your Package</a>
        </div>
    </section>
    
    <section class="about">
        <div class="container">
            <h2>Welcome to Lanka Xpress</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>Welcome to Lanka Express Courier Service! At Lanka Express, we are committed to providing fast, reliable, and secure courier solutions across Sri Lanka. Our mission is to ensure that every package, whether personal or business-related, reaches its destination safely and on time. With our dedicated team and advanced logistics systems, we make shipping seamless and stress-free for all our customers.</p>
                    <p>Our services are designed to cater to both individuals and businesses, offering flexible delivery options, real-time tracking, and professional handling of all parcels. We take pride in maintaining high standards of customer service, efficiency, and trust, ensuring that each delivery experience exceeds expectations.</p>
                    <p>At Lanka Express, your satisfaction is our priority. By choosing us, you are partnering with a courier service that values your time, your packages, and your trust. We look forward to serving you and helping connect you to your world with speed and reliability.</p>
                  </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Prompt Xpress Team">
                </div>
            </div>
        </div>
    </section>

<!-- Services Section -->
<section class="services">
  <div class="container">
    <h2>Our Services</h2>
    <p>Pronto Lanka goes the extra mile in delivering logistics solutions with a portfolio of services to ease our customers' needs.</p>

    <div class="service-cards">
      <div class="card">
        <img src="images/services1.png" alt="Documents & Packages">
        <div class="card-content">
          <h3>Documents & Packages (Parcel Delivery)</h3>
          <p>Fast and secure delivery of your important documents and parcels anywhere in Sri Lanka, ensuring safety and timely arrival.</p>
        </div>
      </div>

      <div class="card">
        <img src="images/services2.png" alt="Courier Mail Bag Services">
        <div class="card-content">
          <h3>Courier Mail Bag Services</h3>
          <p>Efficient management of bulk mail and courier bags for corporate clients, with tracking and delivery confirmation.</p>
        </div>
      </div>

      <div class="card">
        <img src="images/services4.png" alt="Express Delivery">
        <div class="card-content">
          <h3>Express Delivery</h3>
          <p>Priority courier services for urgent shipments, delivering your items quickly and safely with real-time updates.</p>
        </div>
      </div>
      
      <div class="card">
        <img src="images/services3.png" alt="MANAGEMENT OF MAIL ROOM">
        <div class="card-content">
          <h3>Management Of Mail Room</h3>
          <p>We offer tailored mail management solutions that handle collection, sorting, and delivery, ensuring efficient and reliable service for every organization</p>
        </div>
      </div>

      <div class="card">
        <img src="images/services5.png" alt="Express Delivery">
        <div class="card-content">
          <h3>Cash On Delivery</h3>
          <p>Our e-commerce platform offers a secure and convenient way for buyers to 
            receive quality goods and for sellers to trade confidently with guaranteed payments and hassle-free transactions.</p>
        </div>
      </div>

       <div class="card">
        <img src="images/services6.png" alt="Express Delivery">
        <div class="card-content">
          <h3>Medical Delivery</h3>
          <p>We provide trusted medical courier services for healthcare facilities, handling urgent specimens, samples, and supplies with high-quality, reliable, and standards-aligned delivery solutions.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CSS for the Section -->
<style>
.services {
  background: #f9f9f9;
  padding: 20px 0;
  text-align: center;
}

.services h2 {
  font-size: 2.5rem;
  color: #0066cc;
  margin-bottom: 15px;
  position: relative;
}

.services h2::after {
  content: "";
  display: block;
  width: 80px;
  height: 4px;
  background: #ff6600;
  margin: 10px auto 0;
  border-radius: 2px;
}

.services p {
  max-width: 700px;
  margin: 0 auto 50px;
  color: #555;
  font-size: 1rem;
  line-height: 1.6;
}

/* ===== Service Cards Grid ===== */
.service-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 35px;
  justify-items: center;
}

/* ===== Individual Card ===== */
.card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: all 0.4s ease;
  max-width: 380px;
  text-align: left;
}

.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 28px rgba(0, 102, 204, 0.15);
}

/* ===== Large Card Image ===== */
.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.card:hover img {
  transform: scale(1.05);
}

/* ===== Card Content ===== */
.card-content {
  padding: 25px 20px 30px;
}

.card-content h3 {
  font-size: 1.3rem;
  color: #333;
  margin-bottom: 10px;
  font-weight: 600;
}

.card-content p {
  color: #555;
  font-size: 0.95rem;
  line-height: 1.6;
}

/* ===== Responsive Design ===== */
@media (max-width: 768px) {
  .services {
    padding: 60px 20px;
  }

  .services h2 {
    font-size: 2rem;
  }

  .card img {
    height: 180px;
  }

  .card-content {
    padding: 20px 15px 25px;
  }
}
</style>

    
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