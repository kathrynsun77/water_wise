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

$idInt=intval($_POST['cust-id']);

// Insert data into the database
$street= $_POST['building_street'];
$code = intval($_POST['postal_code']);
$unit = $_POST['unit_no'];
$phone=intval($_POST['phone_number']);

$sql = "INSERT INTO address (phone_number,postal_code,building_street,unit_no,customer_id) 
        VALUES ($phone,$code,'$street','$unit',$idInt)";
$conn->query($sql);


$sql3 = "SELECT * FROM address WHERE customer_id=$idInt";

$resulttt = $conn->query($sql3);

// Check if the query returned any rows
if ($resulttt->num_rows > 0) {
    $data = array();
    while ($getData = $resulttt->fetch_assoc()) {
        $data[] = $getData;
    }
    // Login successful
    header("Content-Type: application/json");
    echo json_encode(array(
        "message"=>"Success",
        "data"=>$data[0],
    ));
} else {
    // Login failed
    echo json_encode(array(
        "message"=>"Failed",
    ));

}
$conn->close();
?>
