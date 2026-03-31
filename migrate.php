<?php
// migrate.php - Temporary migration script
header("Content-Type: application/json");

// DATABASE CONNECTION - Update these with your real details
$host = "localhost";
$user = "root";
$pass = "";
$db   = "your_database_name"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed"]));
}

// Get the data from the JavaScript request
$raw_data = file_get_contents("php://input");
$payload = json_decode($raw_data, true);

if (!$payload || !isset($payload['data'])) {
    die(json_encode(["success" => false, "message" => "No data received"]));
}

$fund = $conn->real_escape_string($payload['fund']);
$dataArray = $payload['data'];
$count = 0;

foreach ($dataArray as $item) {
    $date = $conn->real_escape_string($item['date']);
    $check = $conn->real_escape_string($item['check']);
    $payee = $conn->real_escape_string($item['payee']);
    $particulars = $conn->real_escape_string($item['particulars']);
    $amount = (float)$item['amount'];
    $status = $conn->real_escape_string($item['status']);

    // INSERT QUERY - Ensure these column names match your actual table
    $sql = "INSERT INTO checks (fund, date_issued, check_no, payee, particulars, amount, status) 
            VALUES ('$fund', '$date', '$check', '$payee', '$particulars', $amount, '$status')";
    
    if ($conn->query($sql)) {
        $count++;
    }
}

echo json_encode(["success" => true, "message" => "Migrated $count records for $fund"]);
$conn->close();
?>