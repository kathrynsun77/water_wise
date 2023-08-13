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

$sql = "DELETE FROM cart WHERE customer_id=$idUser AND product_id=$product";
$conn->query($sql);

$sql2 = "SELECT * FROM cart JOIN product ON product.product_id=cart.product_id WHERE cart.customer_id=$idUser";
$result = $conn->query($sql2);

if ($result) {
    // Fetch data from the query result and store it in an array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Encode the data array as JSON
    $jsonResponse = json_encode($data);
    // Set the response headers
    header('Content-Type: application/json');
    // Allow cross-origin requests (if needed)
    header('Access-Control-Allow-Origin: *');
    // Send the JSON response
    echo $jsonResponse;
} else {
    echo 'Error executing query: ' . $conn->error;
}

$conn->close();
?>
