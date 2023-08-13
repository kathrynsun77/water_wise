<?php
$servername = "localhost";
$username = "u572492875_admin";
$password = "Waterwise123*";
$database = "u572492875_waterwise";

//$servername = "localhost";
//$username = "root";
//$password = "";
//$database = "water_wise";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}