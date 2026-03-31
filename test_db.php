<?php
$host = 'localhost';
$db   = 'check_registry';
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "✅ Success! Your PHP script is connected to the database.";
    
    // Check if the table exists
    $result = $pdo->query("SHOW TABLES LIKE 'checks'");
    if($result->rowCount() > 0) {
        echo "<br>✅ Table 'checks' found!";
    } else {
        echo "<br>❌ Table 'checks' NOT found. Please check your spelling.";
    }

} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>