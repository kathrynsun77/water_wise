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

// Insert data into the database
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Encrypt the password using bcrypt
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (fname, lname, uname, password, email, mobile, gender, user_type, user_status, photo) VALUES ('$fname', '$lname', '-', '$hashedPassword', '$email', 0, '-', 3, 1, '/assets/images/img_profile1.png')";
$conn->query($sql);

$selectId = "SELECT id FROM users WHERE email='$email';";
$result = $conn->query($selectId);
$row = $result->fetch_assoc();
$idValue = $row['id'];
$idInt = intval($idValue);

$sql2 = "INSERT INTO customer (user_id, region, default_payment_method_type) VALUES ($idInt, '-', 0);";
$conn->query($sql2);

$custId = "SELECT customer_id FROM customer WHERE user_id=$idInt;";
$res = $conn->query($custId);
$roww = $res->fetch_assoc();
$cust = intval($roww['customer_id']);

$sql222 = "INSERT INTO points (total_point,customer_id,point_status) VALUES (0, $cust, 0);";
$conn->query($sql222);

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
    header("Content-Type: application/json");
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
