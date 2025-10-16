<?php
session_start();


if (!isset($_SESSION['user'])) {
    header("Location: loginuser.html");
    exit();
}


$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "delivery_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$loggedInName = $_SESSION['users'];
$updateMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = htmlspecialchars($_POST['name']);
    $newGender = htmlspecialchars($_POST['email']);
    $newPhone = htmlspecialchars($_POST['phone']);
    $newPackage = htmlspecialchars($_POST['password']);

    $updateSql = "UPDATE users SET name=?, email=?, phone=?, password=? WHERE id=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssss", $newName, $newEmail, $newPhone, $newPassword, $loggedInName);

    if ($stmt->execute()) {
        $_SESSION['users'] = $newName; 
        $loggedInName = $newName;
        $updateMessage = "Profile updated successfully.";
    } else {
        $updateMessage = "Error updating profile.";
    }

    $stmt->close();
}

$sql = "SELECT * FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInName);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fitzone Fitness Center</title>
    <link rel="stylesheet" href="profile.css" />
</head>
<body>



<?php if (!empty($updateMessage)) echo "<p style='color:green;'>$updateMessage</p>"; ?>

<?php if ($userData): ?>
<form method="POST" action="userprofile.php" style="margin: 30px;">
<p><a href="index.php">Back to Dashboard</a> | <a href="logout.php">Logout</a></p>
<h2>Edit Profile</h2>
    <label for="name">Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required><br><br>

    <label>Email (not editable):</label><br>
    <input type="email" value="<?= htmlspecialchars($userData['email']) ?>" disabled><br><br>

    <label for="gender">Gender:</label><br>
    <input type="radio" name="gender" value="male" <?= $userData['gender'] == "male" ? "checked" : "" ?>> Male
    <input type="radio" name="gender" value="female" <?= $userData['gender'] == "female" ? "checked" : "" ?>> Female<br><br>

    <label for="phone">Phone Number:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" required><br><br>

    <label>Gym package (not editable):</label><br>
<input type="text" value="<?= htmlspecialchars($userData['package']) ?>" disabled>
<input type="hidden" name="package" value="<?= htmlspecialchars($userData['package']) ?>">
<br><br>

<button type="submit">Update Profile</button>

</form>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>



</body>
</html>
