<?php
session_start();
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    // users table columns: id, name, email, phone, password
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        // ✅ IMPORTANT: createparcel.php uses this
        $_SESSION["customer_id"] = (int)$user["id"];

        header("Location: createparcel.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Login</title>

  <style>
    body{font-family:Arial;background:#eef2f7;padding:40px;}
    .box{max-width:420px;margin:auto;background:#fff;padding:25px;border-radius:14px;box-shadow:0 12px 30px rgba(0,0,0,.12);}
    h2{margin-bottom:15px;}
    input{width:100%;padding:12px;border:1px solid #ccc;border-radius:8px;margin:8px 0;}
    button{width:100%;padding:12px;border:none;border-radius:10px;background:#e63946;color:#fff;font-weight:bold;cursor:pointer;}
    .err{background:#ffe5e5;color:#b00020;padding:10px;border-radius:10px;margin-bottom:10px;}
  </style>
</head>
<body>
  <div class="box">
    <h2>Customer Login</h2>

    <?php if($error): ?>
      <div class="err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
