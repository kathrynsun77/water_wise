<?php
$servername = "139.180.136.45";
// $servername = "localhost";
$username = "root";
$password = "";
$database = "water_wise";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idUser = $_POST['id'];
$idToInt=intval($idUser);

$bill = "SELECT * FROM customer_bill
        JOIN customer ON customer.customer_id = customer_bill.customer_id
        JOIN users ON users.id = customer.user_id
        WHERE users.id =$idToInt";

$result = $conn->query($bill);

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