<?php
session_start();
include ('conn.php');


$email=$_SESSION['email'];
var_dump($email);

$selectName = "SELECT fname FROM users WHERE email='$email';";
$result = $conn->query($selectName);
$row = $result->fetch_assoc();
$nameValue = $row['fname'];
echo $nameValue;
var_dump($nameValue);

$conn->close();
?>
