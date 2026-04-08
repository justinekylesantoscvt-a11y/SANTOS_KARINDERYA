<?php
require_once 'dbconfig.php';

try {
    $name = "Juan Dela Cruz";
    $contact = "09123456789";

    $sql = "INSERT INTO customers (name, contact) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$name, $contact])) {
        echo "Customer added successfully!";
    }
} catch (PDOException $e) {
    echo "Insert failed: " . $e->getMessage();
}
?>