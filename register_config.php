<?php
include ('conn.php');
session_start();
// Insert data into the database
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$_SESSION['email']=$email;

$sql = "INSERT INTO users (fname, lname, uname, password, email, mobile, gender, user_type, user_status) VALUES ('$fname','$lname','-','$password','$email',0,'-',3,1)";
if ($conn->query($sql) === TRUE) {
    echo "User registered successfully!";
} else {
    echo "Failed to register user: " . $conn->error;
}
$selectId = "SELECT id FROM users WHERE email='$email';";
$result = $conn->query($selectId);
$row = $result->fetch_assoc();
$idValue = $row['id'];
$idInt = intval($idValue);

$sql2 = "INSERT INTO customer (user_id, region, e_credit, default_payment_method_type) VALUES ($idInt,'-',0,0);";
if ($conn->query($sql2) === TRUE) {
    echo "Success";
} else {
    echo "Failed Bye Lah" . $conn->error;
}

$conn->close();
?>
