<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "water_wise";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the login form submission
if (isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email']=$username;

    // Query to validate the user's credentials
    $sql = "SELECT * FROM users JOIN customer on users.id=customer.user_id 
            WHERE users.email = '$username' AND users.password = '$password'";
    $result = $conn->query($sql);

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        $data = array();
        while ($getData = $result->fetch_assoc()) {
            $data[] = $getData;
        }
        // Login successful
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
}
$conn->close();
?>
