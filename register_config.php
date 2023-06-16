<?php
// $servername = "localhost";
$servername = "139.180.136.45";
$username = "root";
$password = "";
$database = "water_wise";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Insert data into the database
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO users (fname, lname, uname, password, email, mobile, gender, user_type, user_status,photo) VALUES ('$fname','$lname','-','$password','$email',0,'-',3,1,'img_profile1.png')";
$conn->query($sql);

$selectId = "SELECT id FROM users WHERE email='$email';";
$result = $conn->query($selectId);
$row = $result->fetch_assoc();
$idValue = $row['id'];
$idInt = intval($idValue);

$sql2 = "INSERT INTO customer (user_id, region, e_credit, default_payment_method_type) VALUES ($idInt,'-',0,0);";
$conn->query($sql2);

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
            "message"=>"Success",
            "data"=>$data[0],
        ));
    } else {
        // Login failed
        echo json_encode(array(
            "message"=>"Failed",
        ));

}
$conn->close();
?>
