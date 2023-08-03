<?php
$servername = "localhost";
$username = "id21099494_admin";
$password = "Waterwise123*";
$database = "id21099494_water_wise";

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
$orderId = intval($_POST['orderId']);

$sql3 = "SELECT * FROM orders JOIN order_detail ON orders.order_id=order_detail.order_id 
            JOIN address ON orders.delivery_id=address.address_id 
            JOIN product ON order_detail.product_id=product.product_id
            WHERE orders.order_id=$orderId AND orders.customer_id=$idUser";

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