<?php
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
$id = $_POST['id'];
$idInt = intval($id);
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "UPDATE users SET 
        fname = '$fname',
        lname = '$lname',
        password = '$password',
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
