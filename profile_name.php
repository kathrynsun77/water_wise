<?php
session_start();
$servername = "139.180.136.45";
$username = "root";
$password = "";
$database = "water_wise";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email=$_SESSION['email'];
var_dump($email);

$selectName = "SELECT fname FROM users WHERE email='$email';";
$result = $conn->query($selectName);
$row = $result->fetch_assoc();
$nameValue = $row['fname'];
echo $nameValue;
var_dump($nameValue);

$conn->close();
?>
