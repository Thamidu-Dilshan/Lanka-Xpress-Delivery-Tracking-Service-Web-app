<?php
// branch.php
// Adjust DB settings to match your environment
$servername = "localhost";
$dbusername = "root";
$dbpassword = "1234";
$dbname = "delivery_db";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// fetch branches
$sql = "SELECT id, branch, mobile, landphone FROM branch_network ORDER BY id ASC";
$result = $conn->query($sql);
$branches = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
    }
}
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Lanka Xpress - Branch Network</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="common.css" />
  <link rel="stylesheet" href="network.css" />
  <link rel="stylesheet" href="footer.css" />
  <header>
        <div class="container">
            <div class="header-top">
                <div class="logo">Lanka <span>Xpress</span></div>
                <div class="phone">+94 112 123 456</div>
            </div>
            <nav>
                <ul>
                    <li><a href="home.html">Home</a></li>
                    <li><a href="aboutus.html">About Us</a></li>
                    <li><a href="branch.html">Branch Network</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                    <li><a href="#">Track Your Item</a></li>
                    <div class="auth-buttons">
                        <li><a href="userlogin.php" class="login-btn">Login</a></li>
                        <li><a href="signup.html" class="register-btn">Register</a></li>
                    </div>
                </ul>
            </nav>
        </div>
    </header>
</head>
<body>

<main class="branch-page">
    <div class="branch-container">
      <div class="page-header">
        <h1>Branch Network</h1>
        <div class="meta">Showing <?php echo count($branches); ?> branches</div>
      </div>

      <table id="branches" class="display">
        <thead>
          <tr>
            <th>ID</th>
            <th>Branch</th>
            <th>Mobile</th>
            <th>Landline</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($branches as $b): ?>
          <tr>
            <td><?php echo htmlspecialchars($b['id']); ?></td>
            <td><?php echo htmlspecialchars($b['branch']); ?></td>
            <td><?php echo htmlspecialchars($b['mobile']); ?></td>
            <td><?php echo htmlspecialchars($b['landphone']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>

<!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#branches').DataTable({
      "pageLength": 10,
      "lengthChange": false,
      "language": {
        "paginate": {
          "previous": "Previous",
          "next": "Next"
        },
        "info": "Showing _START_ to _END_ of _TOTAL_ entries"
      }
    });
  });
</script>

 <footer class="footer">
    <div class="footer-main">
        <div class="footer-section programs" style="margin-left: 100px;">
            <h3>Navigation</h3>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="aboutus.html">About Us</a></li>
                <li><a href="branch.html">Branch Network</a></li>
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
            <a href="home.html">
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
