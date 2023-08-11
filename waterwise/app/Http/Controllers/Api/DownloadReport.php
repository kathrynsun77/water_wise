<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pipe;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use mysqli;

class DownloadReport extends Controller
{
    public function addNotif()
    {
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
            return json_encode(array(
                "message"=>"Success",
                "data"=>$data[0],
            ));
        } else {
            // Login failed
            return json_encode(array(
                "message"=>"Failed",
            ));

        }
        $conn->close();
    }
}
