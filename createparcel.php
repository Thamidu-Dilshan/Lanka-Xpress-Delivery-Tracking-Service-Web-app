<?php
session_start();
require_once "db.php";

// ✅ login check (must match userlogin.php)
if (!isset($_SESSION["customer_id"])) {
    header("Location: user_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customer_id = (int)$_SESSION["customer_id"];

    // Safe trim
    $sender_name      = trim($_POST["sender_name"] ?? "");
    $sender_phone     = trim($_POST["sender_phone"] ?? "");
    $sender_address   = trim($_POST["sender_address"] ?? "");

    $receiver_name    = trim($_POST["receiver_name"] ?? "");
    $receiver_phone   = trim($_POST["receiver_phone"] ?? "");
    $receiver_address = trim($_POST["receiver_address"] ?? "");

    $pickup_address   = trim($_POST["pickup_address"] ?? "");
    $delivery_address = trim($_POST["delivery_address"] ?? "");

    $parcel_type      = trim($_POST["parcel_type"] ?? "");
    $weight           = trim($_POST["weight"] ?? "");

    // 1) Insert parcel (tracking_no later)
    $stmt = $conn->prepare("
        INSERT INTO parcels
        (customer_id, sender_name, sender_phone, sender_address,
         receiver_name, receiver_phone, receiver_address,
         pickup_address, delivery_address, parcel_type, weight)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "issssssssss",
        $customer_id,
        $sender_name,
        $sender_phone,
        $sender_address,
        $receiver_name,
        $receiver_phone,
        $receiver_address,
        $pickup_address,
        $delivery_address,
        $parcel_type,
        $weight
    );
    $stmt->execute();

    $parcel_id = $conn->insert_id;

    // 2) Generate tracking number
    $year = date("Y");
    $tracking_no = "LX".$year."-".str_pad((string)$parcel_id, 6, "0", STR_PAD_LEFT);

    // 3) Update parcel tracking_no + status
    $up = $conn->prepare("UPDATE parcels SET tracking_no=?, current_status='Pending' WHERE id=?");
    $up->bind_param("si", $tracking_no, $parcel_id);
    $up->execute();

    // 4) Add first tracking history record
    $status = "Pending";
    $location = "System";
    $note = "Parcel booking created";

    $his = $conn->prepare("INSERT INTO tracking_history (parcel_id, status, location, note) VALUES (?,?,?,?)");
    $his->bind_param("isss", $parcel_id, $status, $location, $note);
    $his->execute();

    // Redirect to my parcels
    header("Location: my_parcels.php?msg=created");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Parcel</title>

<style>
  body {
    font-family: Arial, sans-serif;
    background: linear-gradient(120deg,#f4f7fb,#dde5f0);
    padding: 40px;
  }
  .container {
    max-width: 900px;
    background: white;
    margin: auto;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
  }
  h2 { margin-bottom: 20px; color: #e63946; }
  .section-title { margin-top: 25px; font-weight: bold; color: #333; }
  .grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 15px; }
  input, textarea, select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
  }
  textarea { resize: none; min-height: 90px; }
  button {
    margin-top: 25px;
    padding: 14px;
    width: 100%;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg,#e63946,#a4161a);
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
  }
  button:hover { opacity: 0.9; }
  @media(max-width:768px){ .grid{ grid-template-columns:1fr; } }
</style>
</head>

<body>
<div class="container">
  <h2>📦 Book a Parcel</h2>

  <form method="POST">
    <div class="section-title">Sender Details</div>
    <div class="grid">
      <input name="sender_name" placeholder="Sender Name" required>
      <input name="sender_phone" placeholder="Sender Phone" required>
    </div>
    <textarea name="sender_address" placeholder="Sender Address" required></textarea>

    <div class="section-title">Receiver Details</div>
    <div class="grid">
      <input name="receiver_name" placeholder="Receiver Name" required>
      <input name="receiver_phone" placeholder="Receiver Phone" required>
    </div>
    <textarea name="receiver_address" placeholder="Receiver Address" required></textarea>

    <div class="section-title">Pickup & Delivery</div>
    <div class="grid">
      <textarea name="pickup_address" placeholder="Pickup Address" required></textarea>
      <textarea name="delivery_address" placeholder="Delivery Address" required></textarea>
    </div>

    <div class="section-title">Parcel Info</div>
    <div class="grid">
      <select name="parcel_type" required>
        <option value="">Select Parcel Type</option>
        <option value="Document">Document</option>
        <option value="Box">Box</option>
        <option value="Fragile">Fragile</option>
        <option value="Electronics">Electronics</option>
      </select>
      <input name="weight" placeholder="Weight (e.g. 2kg)" required>
    </div>

    <button type="submit">Create Parcel</button>
  </form>
</div>
</body>
</html>
