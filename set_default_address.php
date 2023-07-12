<?php
//$servername = "sql12.freesqldatabase.com";
//$username = "sql12628993";
//$password = "vYNV8FFHMG";
//$database = "sql12628993";

$servername = "localhost";
$username = "root";
$password = "";
$database = "water_wise";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idUser = $_POST['cust-id'];
$idInt=intval($idUser);
$idAddress = intval($_POST['address_id']);


$setting = "UPDATE customer SET address_id=$idAddress WHERE customer_id =$idInt";
$conn->query($setting);

$sql3 = "SELECT * FROM users 
    JOIN customer ON customer.user_id=users.id 
    WHERE customer.customer_id=$idInt";

$resulttt = $conn->query($sql3);

// Check if the query returned any rows
if ($resulttt->num_rows > 0) {
    $data = array();
    while ($getData = $resulttt->fetch_assoc()) {
        $data[] = $getData;
    }
    // Login successful
    echo json_encode(array(
        "message" => "Success",
        "data" => $data[0],
    ));
} else {
    // Login failed
    echo json_encode(array(
        "message" => "Failed",
    ));
}

$conn->close();
