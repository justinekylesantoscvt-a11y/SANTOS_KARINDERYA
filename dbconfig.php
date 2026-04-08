<?php

session_start(); 

$host = "127.0.0.1"; 
$dbname = "karinderya_db";
$username = "root";
$password = "";
$port = 3307; 

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);
    
   
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("<div style='color:red; background:white; padding:10px;'><h3>Database Connection Error</h3><p>Ensure MySQL is running on port 3307.</p></div>");
}
?>