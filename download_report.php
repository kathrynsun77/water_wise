<?php
require('fpdf/fpdf.php'); // Include the FPDF library
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

$query="SELECT * FROM pipe WHERE customer_id=$idInt";

    // Execute the SQL query
    $result = $conn->query($query);

    // Initialize the FPDF object
    $pdf = new FPDF();
    $pdf->AddPage();

    // Generate the table header
    $pdf->SetFont('Arial', 'B', 12);
    $header = array('Column 1', 'Column 2', 'Column 3');
    foreach ($header as $col) {
        $pdf->Cell(40, 10, $col, 1);
    }
    $pdf->Ln();

    // Generate the table rows
    $pdf->SetFont('Arial', '', 12);
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $col) {
            $pdf->Cell(40, 10, $col, 1);
        }
        $pdf->Ln();
    }

    // Output the PDF file
    $pdf->Output('query_result.pdf', 'D'); // 'D' to force download

    // Close the database connection
    $conn->close();

?>
