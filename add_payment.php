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

// Insert data into the database
$number = $_POST['number'];
$month = $_POST['month'];
$cvv = $_POST['cvv'];
$type=intval($_POST['type']);
$bank_name=$_POST['bank_name'];

$sql = "INSERT INTO payment (bank_name,card_name,card_month,card_cvv,card_type,customer_id) 
        VALUES ('$bank_name','$number','$month',$cvv,$type,$idInt)";
$conn->query($sql);


$sql3 = "SELECT * FROM payment WHERE customer_id=$idInt";

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
