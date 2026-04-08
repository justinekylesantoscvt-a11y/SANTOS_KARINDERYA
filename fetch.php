<?php
require 'dbconfig.php';

$stmt = $conn->query("SELECT * FROM menu_items");
$item = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($item);
echo "</pre>";
?>