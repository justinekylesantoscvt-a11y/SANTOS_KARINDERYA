<?php
require_once 'dbconfig.php';

// Complex SQL: Join customers, orders, order_details, and menu_items
$sql = "SELECT c.name, o.order_date, mi.item_name, od.quantity, od.subtotal, o.total_amount
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN order_details od ON o.order_id = od.order_id
        JOIN menu_items mi ON od.item_id = mi.item_id
        ORDER BY o.order_id DESC"; // Most recent orders first

$stmt = $conn->query($sql);
$orderList = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Justine Lutong Bahay - Order List</title>
    <style>
        body { font-family: sans-serif; background-color: #1a202c; color: white; padding: 20px; }
        .main-panel { background-color: #2d3748; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.3); }
        h2 { text-align: center; border-bottom: 2px solid #3182ce; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #3182ce; padding: 12px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #4a5568; }
        tr:hover { background-color: #4a5568; }
        .action-btns { margin-bottom: 20px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; color: white; cursor: pointer; text-decoration: none; display: inline-block; font-weight: bold; }
        .btn-order { background-color: #e53e3e; } /* Red button like picture */
    </style>
</head>
<body>

    <div class="main-panel">
        <h2>Order Management Dashboard</h2>
        
        <div class="action-btns">
            <a href="menu.php" class="btn btn-order">Create New Order</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Ordered Items (Detailed View)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderList as $order): ?>
                <tr>
                    <td><small><?php echo htmlspecialchars($order['order_date']); ?></small></td>
                    <td><strong><?php echo htmlspecialchars($order['name']); ?></strong></td>
                    <td>
                        <?php echo $order['quantity']; ?>x - <?php echo htmlspecialchars($order['item_name']); ?> 
                        <span style="float:right;">(PHP <?php echo number_format($order['subtotal'], 2); ?>)</span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>