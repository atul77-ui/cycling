<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cycling";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("<div style='color: #ff4d4d; background: #222; padding: 20px; border-radius: 8px; font-family: sans-serif;'>
            <strong>Database Connection Failed:</strong> " . htmlspecialchars($e->getMessage()) . "
        </div>");
}
?>