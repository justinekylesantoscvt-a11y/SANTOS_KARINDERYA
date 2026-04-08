<?php
require 'dbconfig.php';

$stmt = $conn->query("SELECT * FROM customers");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($customers);
echo "</pre>";
?>