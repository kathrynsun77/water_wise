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
$value = $_POST['value'];
$idToInt=intval($idUser);
$status = intval($_POST['status']);

echo "$value, $status";

$sql = "UPDATE points SET total_point = total_point + $value , point_status=$status WHERE customer_id = $idToInt";
$conn->query($sql);

$bill = "INSERT INTO transaction (customer_id, transaction_type, transaction_date, transaction_amount, payment_type, usage_amount, invoice_number) 
        VALUES ($idToInt, 3, '".date("Y-m-d H:i:s")."','$value', '-', 0, '-')";

$conn->query($bill);

$sqll = "SELECT * FROM points 
    JOIN transaction ON points.customer_id = transaction.customer_id 
    WHERE points.customer_id = '$idToInt' AND transaction.transaction_type<>1 
    ORDER BY transaction.transaction_id DESC LIMIT 1";

$result = $conn->query($sqll);

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