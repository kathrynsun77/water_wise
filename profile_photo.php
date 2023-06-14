<?php
session_start();
include ('conn.php');


$email=$_SESSION['email'];
var_dump($email);

$selectName = "SELECT customer.customer_photo FROM customer 
            JOIN users ON customer.user_id=users.id 
            WHERE email='$email';";
$result = $conn->query($selectName);
$row = $result->fetch_assoc();
$nameValue = $row['fname'];
$nameStr = strval($nameValue);
//var_dump($nameStr);
$path="assets/images/$nameStr";

$conn->close();

echo $path;

?>
