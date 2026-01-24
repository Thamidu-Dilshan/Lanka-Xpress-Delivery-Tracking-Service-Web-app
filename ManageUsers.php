<?php
// Success message
if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    echo "<script>alert('User deleted successfully');</script>";
}

// DB Connection
$host = "localhost";
$user = "root";
$password = "1234";
$dbname = "delivery_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Fetch users
$sql = "SELECT id, name, email, phone FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lanka Express - Admin Dashboard</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="admincommon.css" />

  <style>
    .vision { background:#fff; margin:5px; padding:2rem; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.08); }
    .user-table { width: 1195px; border-collapse: collapse; }
    .user-table th, .user-table td { padding:14px; font-size:0.95rem; text-align:left; }
    .user-table thead { background: linear-gradient(135deg, var(--primary), var(--secondary)); color:#fff; }
    .user-table tbody tr:hover { background:#f8f9fa; }
    .btn { border:none; padding:7px 10px; border-radius:8px; cursor:pointer; margin-right:5px; display:inline-flex; align-items:center; justify-content:center; text-decoration:none; }
    .btn.edit { background: rgba(252,163,17,0.15); color:#fca311; }
    .btn.delete { background: rgba(220,53,69,0.15); color:#dc3545; }
  </style>
</head>

<body>
<div class="admin-container">

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2 class="logo"><i class="fas fa-shipping-fast"></i> Lanka Express</h2>
    <ul class="menu">
      <li><a href="admin.html"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li><a href="ManageUsers.php" class="active"><i class="fas fa-users"></i> Manage Users</a></li>
      <li><a href="#"><i class="fas fa-barcode"></i> Generate Tracking</a></li>
      <li><a href="#"><i class="fas fa-search-location"></i> Track Shipment</a></li>
      <li><a href="#"><i class="fas fa-map-marked-alt"></i> Delivery Routes</a></li>
    </ul>
    <a href="logout.php" class="logout-btn">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </aside>

  <!-- Content -->
  <section class="vision">
    <h2><i class="fas fa-users"></i> Manage Users</h2>

    <table class="user-table">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
              <button class="btn edit" type="button"><i class="fas fa-edit"></i></button>

              <a class="btn delete"
              href="deleteuser.php?id=<?= urlencode($row['id']) ?>"
              onclick="return confirm('Are you sure you want to delete this user?');">
              <i class="fas fa-trash"></i>
</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  </section>

</div>
</body>
</html>
