<?php
// $servername = "localhost";
$servername = "sql12.freesqldatabase.com";
$username = "sql12628993";
$password = "vYNV8FFHMG";
$database = "sql12628993";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idUser = $_POST['cust-id'];
$idInt=intval($idUser);

$bill = "SELECT * FROM payment WHERE customer_id =$idInt";

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
