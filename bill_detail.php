<?php
session_start();
include ('conn.php');

$email=$_SESSION['email'];

$bill = "SELECT pipe.pipe_name, pipe.meter FROM pipe 
        JOIN household ON household.id_household=pipe.id_household
        JOIN customer ON customer.customer_id=household.customer_id
        JOIN users ON customer.user_id=users.id
        WHERE users.email='$email'";

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