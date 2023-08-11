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
$idUser = intval($_POST['cust-id']);

$sql3 = "SELECT * FROM orders 
        JOIN transaction ON transaction.invoice_number=orders.order_number
        JOIN payment ON transaction.payment_type=payment.card_payment_id
        JOIN address ON orders.delivery_id=address.address_id 
        WHERE orders.customer_id=$idUser";

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
