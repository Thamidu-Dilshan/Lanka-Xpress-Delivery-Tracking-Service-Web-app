<?php
session_start();
require_once "db.php";

// ✅ Must be logged in + must have customer_id
if (!isset($_SESSION["user"]) || !isset($_SESSION["customer_id"])) {
    header("Location: userlogin.php");
    exit();
}

$customer_id = (int)$_SESSION["customer_id"];

$msg = "";
if (isset($_GET["msg"]) && $_GET["msg"] === "created") {
    $msg = "Parcel created successfully!";
}

// ✅ Fetch parcels with needed fields
$stmt = $conn->prepare("
    SELECT tracking_no, current_status, created_at,
           parcel_type, receiver_name, receiver_phone, receiver_address,
           price
    FROM parcels
    WHERE customer_id=?
    ORDER BY id DESC
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$res = $stmt->get_result();

// ✅ Parcel type -> image map
$typeImages = [
    "Document"    => "images/document.jpg",
    "Box"         => "images/box.jpg",
    "Fragile"     => "images/fragile.jpg",
    "Electronics" => "images/electronic.jpg"
];

function parcelImage($parcelType, $map) {
    $parcelType = trim((string)$parcelType);
    return $map[$parcelType] ?? "images/parcels/default.jpg";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Parcels</title>
  <style>
    body{
      font-family:Arial;
      background:#eef2f7;
      padding:40px;
    }
    .wrap{
      max-width:1050px;
      margin:auto;
      background:#fff;
      padding:25px;
      border-radius:16px;
      box-shadow:0 12px 30px rgba(0,0,0,.12);
    }
    h2{
      margin:0 0 18px 0;
      display:flex;
      align-items:center;
      gap:10px;
      font-size:26px;
    }
    .ok{
      background:#e8fff0;
      color:#1b7f3a;
      padding:10px 12px;
      border-radius:10px;
      margin-bottom:12px;
      font-weight:600;
    }
    .empty{
      padding:14px;
      background:#f6f7fb;
      border:1px dashed #cfd6e6;
      border-radius:10px;
      color:#333;
    }

    /* Card List */
    .list{
      margin-top:12px;
      border-top:1px solid #f0f0f0;
    }
    .row{
      display:flex;
      align-items:flex-start;
      gap:16px;
      padding:16px 6px;
      border-bottom:1px solid #f0f0f0;
    }

    .thumb{
      width:70px;
      height:70px;
      border-radius:10px;
      overflow:hidden;
      flex:0 0 70px;
      border:1px solid #e6e6e6;
      background:#fafafa;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .thumb img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }

    .info{
      flex:1;
      min-width: 300px;
    }
    .topline{
      display:flex;
      align-items:center;
      gap:10px;
      flex-wrap:wrap;
      margin-bottom:6px;
    }
    .type-badge{
      background:#212121;
      color:#fff;
      font-size:12px;
      padding:3px 8px;
      border-radius:6px;
      font-weight:700;
      letter-spacing:.2px;
    }
    .title{
      font-weight:800;
      color:#111;
      font-size:16px;
    }
    .sub{
      color:#6b7280;
      font-size:13px;
      margin:2px 0;
      line-height:1.4;
    }

    .right{
      text-align:right;
      min-width:170px;
      padding-top:4px;
    }
    .price{
      font-weight:800;
      font-size:16px;
      color:#111;
      margin-bottom:10px;
    }
    .status{
      display:inline-block;
      font-size:12px;
      padding:6px 10px;
      border-radius:999px;
      font-weight:800;
      margin-bottom:6px;
    }
    .status.pending{ background:rgba(252,163,17,.15); color:#b45309; }
    .status.delivered{ background:rgba(75,181,67,.15); color:#1b7f3a; }
    .status.other{ background:rgba(59,130,246,.12); color:#1d4ed8; }

    .meta{
      font-size:12px;
      color:#6b7280;
    }

    @media(max-width:850px){
      .row{ flex-direction:column; }
      .right{ text-align:left; min-width:auto; }
      .thumb{ width:90px; height:90px; }
    }

    .track-btn{
  display:inline-block;
  margin-top:18px;
  padding:9px 13px;
  border-radius:10px;
  background:linear-gradient(135deg,#e63946,#a4161a);
  color:#fff;
  font-weight:600;
  font-size:10px;
  text-decoration:none;
  transition:0.2s ease;
}
.track-btn:hover{
  transform:translateY(-2px);
  opacity:0.95;
}

  </style>
</head>
<body>
  <div class="wrap">
    <h2>📦 My Parcels</h2>

    <?php if ($msg): ?>
      <div class="ok"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <?php if ($res->num_rows === 0): ?>
      <div class="empty">No parcels found for your account.</div>
    <?php else: ?>
      <div class="list">
        <?php while ($r = $res->fetch_assoc()): ?>
          <?php
            $img = parcelImage($r["parcel_type"], $typeImages);

            $statusText = trim((string)$r["current_status"]);
            $statusClass = "other";
            if (strcasecmp($statusText, "Pending") === 0) $statusClass = "pending";
            if (strcasecmp($statusText, "Delivered") === 0) $statusClass = "delivered";

            $priceVal = isset($r["price"]) ? (float)$r["price"] : 0;
          ?>

          <div class="row">
            <div class="thumb">
              <img src="<?= htmlspecialchars($img) ?>" alt="parcel">
            </div>

            <div class="info">
              <div class="topline">
                <span class="type-badge"><?= htmlspecialchars($r["parcel_type"]) ?></span>
                <div class="title">
                  Receiver: <?= htmlspecialchars($r["receiver_name"]) ?>
                </div>
              </div>

              <div class="sub"><b>Phone:</b> <?= htmlspecialchars($r["receiver_phone"]) ?></div>
              <div class="sub"><b>Address:</b> <?= htmlspecialchars($r["receiver_address"]) ?></div>
              <div class="sub"><b>Tracking No:</b> <?= htmlspecialchars($r["tracking_no"]) ?></div>
            </div>

            <div class="row-bottom">
    <a class="track-btn" href="track.php?tracking_no=<?= urlencode($r['tracking_no']) ?>">
      Track Package
    </a>
  </div>



            <div class="right">
              <div class="price">Rs. <?= number_format($priceVal, 2) ?></div>

              

              <span class="status <?= $statusClass ?>">
                <?= htmlspecialchars($statusText) ?>
              </span>

              <div class="meta"><?= htmlspecialchars($r["created_at"]) ?></div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>
</body>
</html>
