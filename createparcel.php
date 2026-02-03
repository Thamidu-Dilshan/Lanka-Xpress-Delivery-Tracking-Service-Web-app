<?php
session_start();
require_once "db.php";

// ✅ login check (must match userlogin.php)
if (!isset($_SESSION["user"])) {
    header("Location: userlogin.php");
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

    $sender_city   = trim($_POST["sender_city"] ?? "");
$receiver_city = trim($_POST["receiver_city"] ?? "");

$pay_by         = trim($_POST["pay_by"] ?? "");
$payment_method = trim($_POST["payment_method"] ?? "");


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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Lanka Xpress Delivery Service</title>
  
  <link rel="stylesheet" href="common.css" />
  <link rel="stylesheet" href="createparcel.css" />
  <link rel="stylesheet" href="footer.css" />

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
          <li><a href="admin.html">Track Your Item</a></li>
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

<body>
  

  <main class="cp-page">
    <div class="cp-container">

      <div class="cp-card">
        <div class="cp-card-head">
          <div class="cp-brand">
            <div class="cp-emoji">📦</div>
            <div>
              <h1 class="cp-title">Book a Parcel</h1>
              <p class="cp-subtitle">Fill in sender, receiver and delivery details to create your parcel.</p>
            </div>
          </div>

          <div class="cp-chips">
            <span class="cp-chip"><span class="cp-dot"></span> Secure form</span>
            <span class="cp-chip">⚡ Fast booking</span>
            <span class="cp-chip">🛰️ Trackable</span>
          </div>
        </div>

        <div class="cp-card-body">
          <form method="POST" class="cp-form">

            <!-- Sender -->
            <section class="cp-section">
              <div class="cp-section-top">
                <h2 class="cp-h2">🧑‍💼 Sender Details</h2>
                <small class="cp-hint">* Required</small>
              </div>

              <div class="cp-grid">
                <div class="cp-field">
                  <label class="cp-label">Sender Name <span class="cp-req">*</span></label>
                  <div class="cp-control">
                    <span class="cp-icon">👤</span>
                    <input class="cp-input" name="sender_name" placeholder="e.g. Nimal Perera" required />
                  </div>
                </div>

                <div class="cp-field">
                  <label class="cp-label">Sender Phone <span class="cp-req">*</span></label>
                  <div class="cp-control">
                    <span class="cp-icon">📞</span>
                    <input class="cp-input" name="sender_phone" placeholder="e.g. 07X XXX XXXX" required />
                  </div>
                </div>
              </div>

              <div class="cp-field cp-mt">
                <label class="cp-label">Sender Address <span class="cp-req">*</span></label>
                <textarea class="cp-textarea" name="sender_address" placeholder="House no, street..." required></textarea>
              </div>

              <div class="cp-field">
  <label class="cp-label">Sender City <span class="cp-req">*</span></label>
  <div class="cp-control">
    <span class="cp-icon">🏙️</span>
    <select class="cp-select" name="sender_city" required>
      <option value="">Select City</option>
      <option value="Colombo">Colombo</option>
      <option value="Gampaha">Gampaha</option>
      <option value="Kandy">Kandy</option>
      <option value="Kurunegala">Kurunegala</option>
      <option value="Galle">Galle</option>
      <option value="Matara">Matara</option>
    </select>
    <span class="cp-arrow">▾</span>
  </div>
</div>

            </section>

            

            <!-- Receiver -->
            <section class="cp-section">
              <div class="cp-section-top">
                <h2 class="cp-h2">🎯 Receiver Details</h2>
                <small class="cp-hint">Make sure contact details are correct</small>
              </div>

              <div class="cp-grid">
                <div class="cp-field">
                  <label class="cp-label">Receiver Name <span class="cp-req">*</span></label>
                  <div class="cp-control">
                    <span class="cp-icon">👤</span>
                    <input class="cp-input" name="receiver_name" placeholder="e.g. Kasun Silva" required />
                  </div>
                </div>

                <div class="cp-field">
                  <label class="cp-label">Receiver Phone <span class="cp-req">*</span></label>
                  <div class="cp-control">
                    <span class="cp-icon">📞</span>
                    <input class="cp-input" name="receiver_phone" placeholder="e.g. 07X XXX XXXX" required />
                  </div>
                </div>
              </div>

              <div class="cp-field cp-mt">
                <label class="cp-label">Receiver Address <span class="cp-req">*</span></label>
                <textarea class="cp-textarea" name="receiver_address" placeholder="Apartment, street, city..." required></textarea>
              </div>

              <div class="cp-field">
  <label class="cp-label">Receiver City <span class="cp-req">*</span></label>
  <div class="cp-control">
    <span class="cp-icon">🏙️</span>
    <select class="cp-select" name="receiver_city" required>
      <option value="">Select City</option>
      <option value="Colombo">Colombo</option>
      <option value="Gampaha">Gampaha</option>
      <option value="Kandy">Kandy</option>
      <option value="Kurunegala">Kurunegala</option>
      <option value="Galle">Galle</option>
      <option value="Matara">Matara</option>
    </select>
    <span class="cp-arrow">▾</span>
  </div>
</div>

            </section>

            <!-- Parcel Info -->
            <section class="cp-section">
              <div class="cp-section-top">
                <h2 class="cp-h2">📌 Parcel Info</h2>
                <small class="cp-hint">Select type & weight</small>
              </div>

              <div class="cp-grid">
                <div class="cp-field">
                  <label class="cp-label">Parcel Type <span class="cp-req">*</span></label>
                  <div class="cp-control">
                    <span class="cp-icon">📦</span>
                    <select class="cp-select" name="parcel_type" required>
                      <option value="">Select Parcel Type</option>
                      <option value="Document">Document</option>
                      <option value="Box">Box</option>
                      <option value="Fragile">Fragile</option>
                      <option value="Electronics">Electronics</option>
                    </select>
                    <span class="cp-arrow">▾</span>
                  </div>
                </div>

                <div class="cp-field">
                  <label class="cp-label">Weight <span class="cp-req">*</span></label>
                  <div class="cp-control">
                    <span class="cp-icon">⚖️</span>
                    <input class="cp-input" name="weight" placeholder="e.g. 2 kg" required />
                  </div>
                </div>
              </div>
            </section>

            <!-- Payment -->
<section class="cp-section">
  <div class="cp-section-top">
    <h2 class="cp-h2">💳 Payment Details</h2>
    <small class="cp-hint">Who will pay & how?</small>
  </div>

  <div class="cp-grid">
    <!-- Who Pays -->
    <div class="cp-field">
      <label class="cp-label">Who will pay for delivery? <span class="cp-req">*</span></label>
      <div class="cp-control">
        <span class="cp-icon">👛</span>
        <select class="cp-select" name="pay_by" required>
          <option value="">Select</option>
          <option value="Sender">Sender</option>
          <option value="Receiver">Receiver</option>
        </select>
        <span class="cp-arrow">▾</span>
      </div>
    </div>

    <!-- Payment Method -->
    <div class="cp-field">
      <label class="cp-label">Payment Method <span class="cp-req">*</span></label>
      <div class="cp-control">
        <span class="cp-icon">💰</span>
        <select class="cp-select" name="payment_method" required>
          <option value="">Select</option>
          <option value="Cash">Cash</option>
          <option value="Card">Card</option>
        </select>
        <span class="cp-arrow">▾</span>
      </div>
    </div>
  </div>

  <!-- Estimated Amount Preview -->
<div class="cp-estimate">
  <div class="cp-estimate-left">
    <div class="cp-estimate-title">Estimated Amount</div>
    <div class="cp-estimate-sub">Based on Sender City → Receiver City, parcel type, weight & payment option</div>
  </div>

  <div class="cp-estimate-right">
    <div class="cp-estimate-price" id="cpAmount">Rs 0.00</div>
    <div class="cp-estimate-km" id="cpKm">Distance: 0 km</div>
  </div>
</div>

<!-- send amount to PHP (optional) -->
<input type="hidden" name="amount" id="cpAmountInput" value="0">
<input type="hidden" name="distance_km" id="cpKmInput" value="0">


  <p class="cp-note">
    * If you choose <b>Card</b>, you can complete payment at the branch or via online gateway (optional).
  </p>
</section>


            <!-- Actions -->
            <div class="cp-actions">
              <button class="cp-btn cp-btn-primary" type="submit">✅ Create Parcel</button>
              <button class="cp-btn cp-btn-secondary" type="reset">↩ Reset</button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </main>

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
<script>
(function () {

  // Distance Map (same as PHP map)
  const distanceMap = {
    Colombo:     { Colombo:0,  Gampaha:25,  Kandy:116, Kurunegala:94,  Galle:119, Matara:160 },
    Gampaha:     { Colombo:25, Gampaha:0,   Kandy:95,  Kurunegala:72,  Galle:140, Matara:180 },
    Kandy:       { Colombo:116,Gampaha:95,  Kandy:0,   Kurunegala:41,  Galle:210, Matara:250 },
    Kurunegala:  { Colombo:94, Gampaha:72,  Kandy:41,  Kurunegala:0,   Galle:230, Matara:270 },
    Galle:       { Colombo:119,Gampaha:140, Kandy:210, Kurunegala:230, Galle:0,   Matara:45  },
    Matara:      { Colombo:160,Gampaha:180, Kandy:250, Kurunegala:270, Galle:45,  Matara:0   }
  };

  const elSenderCity   = document.querySelector('[name="sender_city"]');
  const elReceiverCity = document.querySelector('[name="receiver_city"]');
  const elParcelType   = document.querySelector('[name="parcel_type"]');
  const elWeight       = document.querySelector('[name="weight"]');
  const elPayBy        = document.querySelector('[name="pay_by"]');
  const elPayMethod    = document.querySelector('[name="payment_method"]');

  const elAmountText = document.getElementById("cpAmount");
  const elKmText     = document.getElementById("cpKm");
  const elAmountIn   = document.getElementById("cpAmountInput");
  const elKmIn       = document.getElementById("cpKmInput");

  // --- helpers ---
  function parseWeightKg(value) {
    if (!value) return 0;
    let w = String(value).toLowerCase().trim();
    // works in older browsers too
    w = w.replace(/kg/g, "").replace(/\s+/g, "");
    const n = parseFloat(w);
    return isNaN(n) ? 0 : n;
  }

  function getDistanceKm(from, to) {
    if (!from || !to) return 0;
    if (!distanceMap[from] || typeof distanceMap[from][to] === "undefined") return 0;
    return Number(distanceMap[from][to]) || 0;
  }

  function calcAmount(parcelType, weightKg, distanceKm, payBy, paymentMethod) {

    // ✅ IMPORTANT: if cities not selected or distance 0 (different city not selected yet)
    // show 0 until sender+receiver cities are selected
    if (!parcelType || distanceKm === 0) {
      // allow same city case => distance 0 but still charge should apply
      // so only return 0 when city fields are missing
      // We'll handle missing cities in updateEstimate()
    }

    // base
    let base = 300;
    if (parcelType === "Document") base = 250;
    if (parcelType === "Box") base = 350;
    if (parcelType === "Fragile") base = 450;
    if (parcelType === "Electronics") base = 500;

    // distance charge
    let distanceCharge = 120;
    if (distanceKm <= 5) distanceCharge = 120;
    else if (distanceKm <= 15) distanceCharge = 220;
    else if (distanceKm <= 30) distanceCharge = 350;
    else if (distanceKm <= 60) distanceCharge = 600;
    else if (distanceKm <= 120) distanceCharge = 950;
    else distanceCharge = 1400;

    // weight charge
    let weightCharge = 0;
    if (weightKg <= 1) weightCharge = 0;
    else if (weightKg <= 3) weightCharge = 150;
    else if (weightKg <= 5) weightCharge = 300;
    else if (weightKg <= 10) weightCharge = 600;
    else weightCharge = 1000;

    // rider fee
    const riderFee = 200;

    // COD fee
    let codFee = 0;
    if (payBy === "Receiver" && paymentMethod === "Cash") codFee = 120;

    return base + distanceCharge + weightCharge + riderFee + codFee;
  }

  function setUi(amount, km) {
    if (elKmText) elKmText.textContent = `Distance: ${km} km`;
    if (elAmountText) elAmountText.textContent = `Rs ${amount.toFixed(2)}`;
    if (elAmountIn) elAmountIn.value = amount.toFixed(2);
    if (elKmIn) elKmIn.value = String(km);
  }

  function updateEstimate() {
    const senderCity   = elSenderCity ? elSenderCity.value : "";
    const receiverCity = elReceiverCity ? elReceiverCity.value : "";
    const parcelType   = elParcelType ? elParcelType.value : "";
    const weightKg     = parseWeightKg(elWeight ? elWeight.value : "");
    const payBy        = elPayBy ? elPayBy.value : "";
    const payMethod    = elPayMethod ? elPayMethod.value : "";

    // ✅ Only calculate when BOTH cities selected
    if (!senderCity || !receiverCity) {
      setUi(0, 0);
      return;
    }

    const km = getDistanceKm(senderCity, receiverCity);

    // ✅ parcel type required for estimate; if not selected show 0 but show distance
    if (!parcelType) {
      setUi(0, km);
      return;
    }

    const amount = calcAmount(parcelType, weightKg, km, payBy, payMethod);
    setUi(amount, km);
  }

  // attach listeners (input/change both for select)
  [elSenderCity, elReceiverCity, elParcelType, elPayBy, elPayMethod]
    .filter(Boolean)
    .forEach(el => {
      el.addEventListener("change", updateEstimate);
      el.addEventListener("input", updateEstimate);
    });

  if (elWeight) {
    elWeight.addEventListener("input", updateEstimate);
    elWeight.addEventListener("change", updateEstimate);
  }

  // initial
  updateEstimate();

})();
</script>


</html>
