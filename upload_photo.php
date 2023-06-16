<?php
$servername = "139.180.136.45";
// $servername = "localhost";
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
$idUser = $_POST['id'];
$idInt = intval($idUser);

$sql="UPDATE customer SET customer_photo='$photo_name' WHERE user_id=$idInt";
if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Failed Bye Lah" . $conn->error;
}

$conn->close();


?>
