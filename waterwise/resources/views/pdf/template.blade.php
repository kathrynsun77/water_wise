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
    <tbody>
    @foreach ($results as $result)
    <tr>
        <td>{{ $result->pipe_name }}</td>
        <td>  @if (intval($result->leak_status) === 1)
            No Leak
            @else
            Leaking
            @endif
        </td>
        <td>{{ $result->meter_value }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
