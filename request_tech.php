<?php
//$servername = "sql12.freesqldatabase.com";
//$username = "sql12628993";
//$password = "vYNV8FFHMG";
//$database = "sql12628993";

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
$idUser = $_POST['cust-id'];
$idInt=intval($idUser);
$mysqltime = date('Y-m-d H:i:s');
$pipe = intval($_POST['pipe']);

$sql2222 = "UPDATE pipe SET pending = $pipe WHERE customer_id = $idInt";
$conn->query($sql2222);

    // Query to validate the user's credentials
    $sql = "INSERT INTO service (customer_id,service_date,service_description) 
            VALUES ($idInt,'".date("Y-m-d H:i:s")."','pipe leaks')";

    $result = $conn->query($sql);

    $sql2="SELECT * FROM service WHERE customer_id=$idInt";
    $res= $conn->query($sql2);

    // Check if the query returned any rows
    if ($res->num_rows > 0) {
        $data = array();
        while ($getData = $res->fetch_assoc()) {
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
$conn->close();
?>