<?php
require 'dbconfig.php';

$sql = "DELETE FROM customers WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([3]);

echo "Customer deleted!";
?>