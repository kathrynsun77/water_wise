<?php
// $servername = "localhost";
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

$idUser = $_POST['cust-id'];
$idInt=intval($idUser);

// Insert data into the database
$number = $_POST['number'];
$month = $_POST['month'];
$cvv = $_POST['cvv'];
$type=intval($_POST['type']);

$sql = "INSERT INTO card_payment (card_name,card_month,card_year,card_cvv,card_type,customer_id) 
        VALUES ('$number','$month',0,$cvv,$type,$idInt)";
$conn->query($sql);


$sql3 = "SELECT * FROM card_payment WHERE customer_id=$idInt";

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
