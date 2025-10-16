<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "delivery_db";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $sql = "INSERT INTO users (name, email, phone, password) 
                VALUES ('$name', '$email', '$phone', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $message = "Signup successful. <a href='home.php'>Click here to login</a>";
            echo "<script>alert('Signup successful.'); window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Signup failed: " . $conn->error . "'); window.history.back();</script>";
        }
    }

    $conn->close();
}
?>
