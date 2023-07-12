<?php
// $servername = "localhost";
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
$amount = intval($_POST['amount']);
$usage = 0;
$today = date("Ymd");
$rand = sprintf("%04d", rand(0,9999));
$invoice = $today . $rand;
$payment_type=$_POST['payment-id'];
$mysqltime = date('Y-m-d H:i:s');
$newCreditValue = intval($amount * 0.05 * 0.1);
$point= intval($_POST['point']);
$address= intval($_POST['address']);

//insert transaction
$sql = "INSERT INTO transaction (customer_id,transaction_type,transaction_date,transaction_amount,payment_type,usage_amount,invoice_number) 
            VALUES ($idInt,1,'".date("Y-m-d H:i:s")."',$amount,'$payment_type',$usage,'$invoice')";
$result = $conn->query($sql);

//if reedem point
if ($point > 0) {
    $sql8 = "INSERT INTO transaction (customer_id, transaction_type, transaction_date, transaction_amount, payment_type, usage_amount, invoice_number) 
        VALUES ($idInt, 2, '".date("Y-m-d H:i:s")."', $point, '-', 0, '-')";
    $conn->query($sql8);

    $sql9 = "UPDATE points SET total_point = 0 WHERE customer_id = $idInt";
    $conn->query($sql9);
}

//insert into order
$sql3 = "INSERT INTO orders (customer_id,amount,tracking_number,delivery_id,order_number) VALUES ($idInt,$amount,'-',$address,'$invoice')";
$conn->query($sql3);

// Retrieve the last inserted order_id
$orderID = mysqli_insert_id($conn);

//insert to order_details
$sqlDetail = "INSERT INTO order_detail (order_id, product_id, qty)
SELECT $orderID, product_id, qty FROM cart WHERE cart.customer_id = $idInt;";
$conn->query($sqlDetail);

// Check if the row with customer ID exists
$sqlCheck = "SELECT customer_id FROM points WHERE customer_id = $idInt";
$resultCheck = $conn->query($sqlCheck);

if ($resultCheck->num_rows > 0) {
    // Row exists, so run the update statement
    $sql = "UPDATE points SET total_point = total_point + $newCreditValue WHERE customer_id = $idInt";
    $conn->query($sql);

    $sql00 = "INSERT INTO transaction (customer_id, transaction_type, transaction_date, transaction_amount, payment_type, usage_amount, invoice_number) 
        VALUES ($idInt, 3, '".date("Y-m-d H:i:s")."', $newCreditValue, '-', 0, '-')";
    $conn->query($sql00);

} else {
    // Row doesn't exist, so run the insert statement
    $sql = "INSERT INTO points (total_point, customer_id) VALUES ($newCreditValue, $idInt)";
    $conn->query($sql);

    $sql00 = "INSERT INTO transaction (customer_id, transaction_type, transaction_date, transaction_amount, payment_type, usage_amount, invoice_number) 
        VALUES ($idInt, 3, '".date("Y-m-d H:i:s")."', $newCreditValue, '-', 0, '-')";
    $conn->query($sql00);
}

$sqlDel = "DELETE FROM cart WHERE customer_id=$idInt";
$conn->query($sqlDel);

$sql2="SELECT * FROM transaction WHERE customer_id=$idInt ORDER BY transaction_id DESC LIMIT 3";
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
