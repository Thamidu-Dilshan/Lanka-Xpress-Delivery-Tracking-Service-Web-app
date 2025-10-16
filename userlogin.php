<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "delivery_db";

   
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_email = $_POST['username'];
    $user_password = $_POST['password'];

   
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($user_password, $row['password'])) {
            $_SESSION['user'] = $row['name'];
            echo "<script>
                alert('User Login successful.');
                window.location.href = 'home.php';
            </script>";
            exit();
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lanka Xpress Delivery Service</title>
  <link rel="stylesheet" href="common.css" />
  <link rel="stylesheet" href="userlogin.css" />
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
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="branch.php">Branch Network</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Track Your Item</a></li>
                <li class="auth-buttons">
                    <a href="userlogin.php" class="login-btn">Login</a>
                    <a href="signup.html" class="register-btn">Register</a>
                </li>
            </ul>
        </nav>
    </div>
</header>


<div class="login-page">
    <div class="login-container">
        <h2>Login</h2>

      
        <?php if($message != "") { ?>
            <p style="color:red; font-weight:600; margin-bottom:15px;"><?php echo $message; ?></p>
        <?php } ?>

        
        <form method="POST" action="userlogin.php">
            <div class="input-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btnlogin">Login</button>

            <p style="margin-top: 15px;">
                <a href="#">Forgot Password?</a>
            </p>
        </form>
    </div>
</div>


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
