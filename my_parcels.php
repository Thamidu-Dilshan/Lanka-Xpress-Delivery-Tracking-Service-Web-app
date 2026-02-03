<?php
session_start();
require_once "db.php";

// ✅ Must be logged in + must have customer_id (set in userlogin.php)
if (!isset($_SESSION["user"]) || !isset($_SESSION["customer_id"])) {
    header("Location: userlogin.php");
    exit();
}

$customer_id = (int)$_SESSION["customer_id"];

$msg = "";
if (isset($_GET["msg"]) && $_GET["msg"] === "created") {
    $msg = "Parcel created successfully!";
}

// ✅ Fetch parcels for this customer
$stmt = $conn->prepare("
    SELECT tracking_no, current_status, created_at
    FROM parcels
    WHERE customer_id=?
    ORDER BY id DESC
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Parcels</title>
  <style>
    body{font-family:Arial;background:#eef2f7;padding:40px;}
    .wrap{max-width:900px;margin:auto;background:#fff;padding:25px;border-radius:14px;box-shadow:0 12px 30px rgba(0,0,0,.12);}
    h2{margin-bottom:15px;}
    table{width:100%;border-collapse:collapse;}
    th,td{padding:12px;border-bottom:1px solid #eee;text-align:left;}
    th{background:#e63946;color:#fff;}
    .ok{background:#e8fff0;color:#1b7f3a;padding:10px;border-radius:10px;margin-bottom:12px;}
    .empty{padding:14px;background:#f6f7fb;border:1px dashed #cfd6e6;border-radius:10px;color:#333;}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>My Parcels</h2>

    <?php if ($msg): ?>
      <div class="ok"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <?php if ($res->num_rows === 0): ?>
      <div class="empty">No parcels found for your account.</div>
    <?php else: ?>
      <table>
        <tr>
          <th>Tracking No</th>
          <th>Status</th>
          <th>Created</th>
        </tr>

        <?php while ($r = $res->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($r["tracking_no"]) ?></td>
            <td><?= htmlspecialchars($r["current_status"]) ?></td>
            <td><?= htmlspecialchars($r["created_at"]) ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php endif; ?>

  </div>
</body>
</html>

