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

// Process the login form submission
if (isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch the user's record by email
    $sql = "SELECT * FROM users JOIN customer ON users.id = customer.user_id 
            WHERE users.email = '$username'";
    $result = $conn->query($sql);

    // Check if the query returned any rows
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password matches, login successful
            echo json_encode(array(
                "message" => "Success",
                "data" => $row,
            ));
        } else {
            // Password does not match, login failed
            echo json_encode(array(
                "message" => "Failed",
            ));
        }
    } else {
        // User not found, login failed
        echo json_encode(array(
            "message" => "Failed",
        ));
    }
}

$conn->close();
?>
