<?php
require 'dbconfig.php';

$sql = "SELECT customers.name, menu_items.item_name, order_details.quantity
        FROM order_details
        JOIN orders ON order_details.order_id = orders.order_id
        JOIN customers ON orders.customer_id = customers.customer_id
        JOIN menu_items ON order_details.menu_id = menu_items.menu_id
        WHERE customers.name = 'Juan Dela Cruz'";

$stmt = $conn->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($data);
echo "</pre>";
?>