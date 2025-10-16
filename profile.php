<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: userlogin.php");
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

$loggedInName = $_SESSION['user'];
$updateMessage = "";

// Fetch user details
$sql = "SELECT * FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInName);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();

// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = htmlspecialchars($_POST['name']);
    $newPhone = htmlspecialchars($_POST['phone']);
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';

    // Update name and phone
    $updateSql = "UPDATE users SET name = ?, phone = ? WHERE name = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sss", $newName, $newPhone, $loggedInName);
    $stmt->execute();
    $stmt->close();

    // If password fields filled, verify and update password
    if (!empty($currentPassword) && !empty($newPassword)) {
        // Fetch current password hash
        $sql = "SELECT password FROM users WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $loggedInName);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($currentPassword, $user['password'])) {
            // Hash new password and update
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePass = "UPDATE users SET password = ? WHERE name = ?";
            $stmt = $conn->prepare($updatePass);
            $stmt->bind_param("ss", $hashedPassword, $loggedInName);
            $stmt->execute();
            $stmt->close();
            $updateMessage = "Profile and password updated successfully.";
        } else {
            $updateMessage = "Current password is incorrect.";
        }
    } else {
        $updateMessage = "Profile updated successfully.";
    }

    // Refresh session name if updated
    $_SESSION['user'] = $newName;
    $loggedInName = $newName;
}

// Re-fetch updated data
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
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css" />
    <script>
        function showPopup(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showPopup('<?= htmlspecialchars($updateMessage) ?>')">

<form method="POST" action="profile.php" style="margin: 30px;">
    <p><a href="home.php">Back to Dashboard</a> | <a href="logout.php">Logout</a></p>
    <h2>Edit Profile</h2>

    <label for="name">Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required><br><br>

    <label>Email (not editable):</label><br>
    <input type="email" value="<?= htmlspecialchars($userData['email']) ?>" disabled><br><br>

    <label for="phone">Phone Number:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" required><br><br>

    <label for="current_password">Current Password:</label><br>
    <input type="password" name="current_password" placeholder="Enter current password"><br><br>

    <label for="new_password">New Password:</label><br>
    <input type="password" name="new_password" placeholder="Enter new password"><br><br>

    <button type="submit">Update Profile</button>
</form>

</body>
</html>
