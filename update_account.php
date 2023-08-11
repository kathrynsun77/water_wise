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
$id = $_POST['id'];
$idInt = intval($id);
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET 
        fname = '$fname',
        lname = '$lname',
        password = '$hashedPassword',
        email = '$email'
        WHERE id = '$idInt'";

$conn->query($sql);

$sql3 = "SELECT * FROM users 
    JOIN customer ON customer.user_id=users.id 
    WHERE users.id=$idInt";

$resulttt = $conn->query($sql3);

// Check if the query returned any rows
if ($resulttt->num_rows > 0) {
    $data = array();
    while ($getData = $resulttt->fetch_assoc()) {
        $data[] = $getData;
    }
    // Login successful
    echo json_encode(array(
        "message" => "Success",
        "data" => $data[0],
    ));
} else {
    // Login failed
    echo json_encode(array(
        "message" => "Failed",
    ));
}

$conn->close();
?>
