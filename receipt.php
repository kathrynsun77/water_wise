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
$idUser = $_POST['cust-id'];
$idInt=intval($idUser);
$invoice = $_POST['invoice'];

$sql3 = "SELECT * FROM customer_bill JOIN transaction ON transaction.invoice_number=customer_bill.inovice_number 
            JOIN payment ON payment.card_payment_id=transaction.payment_type WHERE inovice_number='$invoice'";

$result = $conn->query($sql3);

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