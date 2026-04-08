<?php
require_once 'dbconfig.php';

if (isset($_POST['checkout'])) {
    // 1. Get Basic Data
    $customerId = $_POST['customer_id'];
    $totalAmount = $_POST['total_amount'];

    // 2. Validate Cart
    if (empty($_SESSION['cart'])) {
        die("Your order cart is empty. Cannot process.");
    }

    try {
        // We use a database transaction to ensure total consistency
        $conn->beginTransaction();

        // 3. Create the Main Order Entry (Primary Key)
        $sqlOrder = "INSERT INTO orders (customer_id, total_amount, status) VALUES (?, ?, 'Completed')";
        $stmtOrder = $conn->prepare($sqlOrder);
        $stmtOrder->execute([$customerId, $totalAmount]);
        
        // 4. Get the Order ID just created (Foreign Key)
        $orderId = $conn->lastInsertId();

        // 5. Create the Order Details Entry (Complexity Join)
        // We prepare the statement once for efficiency
        $sqlDetail = "INSERT INTO order_details (order_id, item_id, quantity, subtotal) VALUES (?, ?, ?, ?)";
        $stmtDetail = $conn->prepare($sqlDetail);

        foreach ($_SESSION['cart'] as $item) {
            $itemId = $item['item_id'];
            $quantity = $item['quantity'];
            $subtotal = $item['price'] * $quantity;
            
            // Execute for each item in the cart
            $stmtDetail->execute([$orderId, $itemId, $quantity, $subtotal]);
        }

        // 6. Finalize Transaction and Clear Session
        $conn->commit();
        unset($_SESSION['cart']);
        echo "<script>alert('Order Processed Successfully! Redirecting to Order List...'); window.location='table.php';</script>";

    } catch (PDOException $e) {
        $conn->rollBack();
        die("Critical Error processing order: " . $e->getMessage());
    }
} else {
    header('Location: menu.php');
}
?>