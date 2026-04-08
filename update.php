<?php
require 'dbconfig.php';

$sql = "UPDATE customers SET phone = ? WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(['09999999999', 1]);

echo "Customer updated!";
?>