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

$idUser = $_POST['cust-id'];
$idInt=intval($idUser);

// Insert data into the database
$title = $_POST['title'];
$body = $_POST['body'];


$sql = "INSERT INTO notification (notification_name,message,customer_id,status,url) 
        VALUES ('$title','$body', $idInt, 0, '')";
$conn->query($sql);


$sql3 = "SELECT * FROM notification WHERE customer_id=$idInt ORDER BY notification_date DESC";

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
