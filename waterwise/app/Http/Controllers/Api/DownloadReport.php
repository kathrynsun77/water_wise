<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pipe;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DownloadReport extends Controller
{
    public function generatePdf(Request $request)
    {
        // Get the cust-id from the POST request sent from Flutter
        $customerId = intval($request->input('cust-id'));
//        $customerId=1;

        // Replace the following code with your SQL query logic
        $results=pipe::where('customer_id',$customerId)->get();


        // Generate PDF using the query results
        // Generate the HTML content for the PDF
        $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
                    th, td {
                        padding: 8px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }
                </style>
            </head>
            <body>
                <h1>Water Usage Report</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Pipe Name</th>
                            <th>Leak Status</th>
                            <th>Meter Value</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($results as $result) {
            $html .= '
                        <tr>
                            <td>'.$result->pipe_name.'</td>
                            <td>'.(intval($result->leak_status) === 1 ? 'No Leak' : 'Leaking').'</td>
                            <td>'.$result->meter_value.'</td>
                        </tr>';
        }

        $html .= '
                    </tbody>
                </table>
            </body>
            </html>
        ';

        // Generate PDF using the HTML content
        $pdf = PDF::loadHTML($html);
        // Generate a unique filename for the PDF
        $filename = 'water_usage' . '.pdf';

        // Save the PDF file locally
        $pdf->save(public_path('pdf/' . $filename));

        // Return the file download response
        return response()->download(public_path('pdf/' . $filename))->deleteFileAfterSend(true);
    }
}
