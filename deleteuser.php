<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$password = "1234";
$dbname = "delivery_db";

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8mb4");

if (!isset($_GET['id'])) {
    die("Missing id");
}

$id = (int)$_GET['id'];

// (Optional) check record exists first
$check = $conn->prepare("SELECT id FROM users WHERE id=?");
$check->bind_param("i", $id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows === 0) {
    die("User not found (id=$id)");
}

// Delete
$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ManageUsers.php?msg=deleted");
exit();
?>
