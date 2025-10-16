<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | Lanka Xpress</title>
  <link rel="stylesheet" href="contactus.css" />
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
                    <li><a href="#">Contact Us</a></li>
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
                </ul>
            </nav>
        </div>
    </header>
  <section class="contact-section">
    <div class="contact-container">
      <!-- Left Contact Info -->
      <div class="contact-info">
        <h2>Contact Details</h2>
        <ul>
          <li><strong>📍 Head Office:</strong> No. 50, Galle Road, Colombo 6, Sri Lanka</li>
          <li><strong>📧 Email:</strong> info@lankaxpress.com</li>
          <li><strong>📞 Telephone:</strong> (+94) 112 123 456</li>
          <li><strong>📠 Fax:</strong> (+94) 112 368 010</li>
        </ul>

        <h2>Opening Hours</h2>
        <ul class="hours">
          <li>Monday - Friday: <span>08:30 - 17:30</span></li>
          <li>Saturday: <span>08:30 - 17:30</span></li>
        </ul>
      </div>

      <!-- Right Contact Form -->
      <div class="contact-form">
        <h1>Contact Us</h1>
        <form method="POST" action="contactus.php">
          <select name="inquiry_type" required>
            <option value="">I have an inquiry to make</option>
            <option value="Delivery Inquiry">Delivery Inquiry</option>
            <option value="Customer Support">Customer Support</option>
            <option value="Feedback">Feedback</option>
          </select>

          <input type="text" name="subject" placeholder="Subject *" required />

          <div class="row">
            <input type="text" name="first_name" placeholder="First Name *" required />
            <input type="text" name="last_name" placeholder="Last Name *" required />
          </div>

          <div class="row">
            <input type="text" name="mobile" placeholder="Mobile No *" required />
            <input type="email" name="email" placeholder="Email Address *" required />
          </div>

          <div class="row">
            <select name="item_type" required>
              <option value="">Select Item Type *</option>
              <option value="Parcel">Parcel</option>
              <option value="Document">Document</option>
            </select>

            <select name="service_type" required>
              <option value="">Select Service Type *</option>
              <option value="Express">Express</option>
              <option value="Standard">Standard</option>
            </select>
          </div>

          <textarea name="message" placeholder="Your Message *" required></textarea>
          <button type="submit" name="submit">Submit</button>
        </form>
      </div>
    </div>
  </section>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Database connection
      $conn = new mysqli("localhost", "root", "1234", "delivery_db");

      if ($conn->connect_error) {
          die("<script>alert('Database connection failed.');</script>");
      }

      // Sanitize input
      $inquiry_type = htmlspecialchars($_POST['inquiry_type']);
      $subject = htmlspecialchars($_POST['subject']);
      $first_name = htmlspecialchars($_POST['first_name']);
      $last_name = htmlspecialchars($_POST['last_name']);
      $mobile = htmlspecialchars($_POST['mobile']);
      $email = htmlspecialchars($_POST['email']);
      $item_type = htmlspecialchars($_POST['item_type']);
      $service_type = htmlspecialchars($_POST['service_type']);
      $message = htmlspecialchars($_POST['message']);

      // Insert query
      $sql = "INSERT INTO contact_messages 
              (inquiry_type, subject, first_name, last_name, mobile, email, item_type, service_type, message)
              VALUES ('$inquiry_type', '$subject', '$first_name', '$last_name', '$mobile', '$email', '$item_type', '$service_type', '$message')";

      if ($conn->query($sql) === TRUE) {
          echo "<script>alert('Your message has been sent successfully!'); window.location='contactus.php';</script>";
      } else {
          echo "<script>alert('Error submitting message. Please try again.');</script>";
      }

      $conn->close();
  }
  ?>
  <footer class="footer">
    <div class="footer-main">
        <div class="footer-section programs" style="margin-left: 100px;">
            <h3>Navigation</h3>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="branch.php">Branch Network</a></li>
                <li><a href="#">Contact Us</a></li>
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
