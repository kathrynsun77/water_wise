<?php
require_once 'conn.php';

//$servername = "localhost";
//$username = "u572492875_admin";
//$password = "Waterwise123*";
//$database = "u572492875_waterwise";
//
////$servername = "localhost";
////$username = "root";
////$password = "";
////$database = "water_wise";
//
//// Create connection
//$conn = new mysqli($servername, $username, $password, $database);
//
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

$idUser = intval($_POST['cust-id']);
$product = intval($_POST['product']);
$qty = intval($_POST['qty']);

$sql2 = "SELECT * FROM cart WHERE customer_id=$idUser AND product_id=$product";
$result = $conn->query($sql2);

if ($result->num_rows > 0) {
    $sql = "UPDATE cart SET qty = qty + $qty WHERE customer_id=$idUser AND product_id=$product";
    $conn->query($sql);
} else {
    $sql = "INSERT INTO cart (customer_id,product_id,qty) VALUES ($idUser,$product,$qty)";
    $conn->query($sql);
}

$sql3 = "SELECT * FROM cart WHERE customer_id=$idUser AND product_id=$product";

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
