<?php
require_once 'dbconfig.php';

// Add this at the top of menu.php
if (isset($_GET['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: menu.php");
    exit();
}
// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $itemArray = array(
        'item_id' => $itemId,
        'item_name' => $itemName,
        'price' => $price,
        'quantity' => $quantity
    );

    // Create session cart if it doesn't exist
    if (empty($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add or update quantity in cart
    $_SESSION['cart'][$itemId] = $itemArray;
    echo "<script>alert('Added to cart!'); window.location='menu.php';</script>";
}

// Fetch all menu items from database
$stmt = $conn->query("SELECT * FROM menu_items ORDER BY FIELD(category, 'Rice Meal', 'Ulam', 'Drink', 'Dessert'), item_name");
$menuItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Justine Lutong Bahay - Place Order</title>
    <style>
        body { font-family: sans-serif; background-color: #f7fafc; padding: 20px; }
        .container { display: flex; gap: 20px; }
        .menu-list { flex: 2; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .cart { flex: 1; background: #2d3748; color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .cart td, .cart th { border-bottom: 1px solid #4a5568; }
        .btn { background-color: #3182ce; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-success { background-color: #48bb78; }
        input[type="number"] { width: 50px; padding: 5px; }
    </style>
</head>
<body>

    <h1>Justine Lutong Bahay: Menu</h1>
    <div class="container">
        
        <div class="menu-list">
            <h2>Our Specials</h2>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menuItems as $item): ?>
                    <tr>
                        <form method="post" action="">
                            <td><small><?php echo htmlspecialchars($item['category']); ?></small></td>
                            <td>
                                <strong><?php echo htmlspecialchars($item['item_name']); ?></strong><br>
                                <small style="color:#718096;"><?php echo htmlspecialchars($item['description']); ?></small>
                            </td>
                            <td>PHP <?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                <input type="hidden" name="item_name" value="<?php echo $item['item_name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                                <input type="number" name="quantity" value="1" min="1">
                                <button type="submit" name="add_to_cart" class="btn">Add</button>
                            </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="cart">
            <h2>Current Order</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <table>
                    <thead><tr><th>Item</th><th>Qty</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $item): 
                            $sub = $item['price'] * $item['quantity'];
                            $total += $sub;
                        ?>
                        <tr>
                            <td><?php echo $item['item_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($sub, 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr style="font-weight:bold;"><td colspan="2">TOTAL:</td><td>PHP <?php echo number_format($total, 2); ?></td></tr>
                    </tbody>
                </table>
                <br>
                <form action="process_order.php" method="post">
                    <label>Customer ID (Use 1 or 2):</label><br>
                    <input type="number" name="customer_id" required><br><br>
                    <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                    <button type="submit" name="checkout" class="btn-success btn">Check Out Order</button>
                    <a href="menu.php?clear_cart=1" style="color:#fc8181; float:right; text-decoration:none;">Clear Cart</a>
                </form>
            <?php else: ?>
                <p>Your order is empty.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>