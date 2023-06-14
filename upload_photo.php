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
//retrieve photo from flutter
$photo_name = $_POST['customer_photo'];

$email=$_SESSION['email'];

$selectId="SELECT id from users where email='$email'";
$result = $conn->query($selectId);
$row = $result->fetch_assoc();
$idValue = $row['id'];
$idInt = intval($idValue);

$sql="UPDATE customer SET customer_photo='$photo_name' WHERE user_id=$idInt";
if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Failed Bye Lah" . $conn->error;
}

$conn->close();


?>
