<?php
require_once '../config.php';
if(empty($_SESSION['admin_logged'])) { header('Location: login.php'); exit; }

// Handle Product Add/Delete
if(isset($_POST['add_product'])) {
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['image'], $_POST['category']]);
    header('Location: index.php');
    exit;
}

if(isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: index.php');
    exit;
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
$orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <div class="logo">Admin Dashboard</div>
        <nav><a href="logout.php">Logout</a></nav>
    </header>

    <div class="container">
        <h2>Manage Products</h2>
        <form method="POST" style="background:#f9f9f9; padding:20px; margin-bottom:30px;">
            <input type="text" name="name" placeholder="Product Name" required style="margin-bottom:10px; width:100%; padding:8px;">
            <textarea name="description" placeholder="Description" style="margin-bottom:10px; width:100%; padding:8px;"></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price (ZMW)" required style="margin-bottom:10px; width:100%; padding:8px;">
            <input type="text" name="image" placeholder="Image URL / Path" value="assets/placeholder.jpg" style="margin-bottom:10px; width:100%; padding:8px;">
            <input type="text" name="category" placeholder="Category" style="margin-bottom:10px; width:100%; padding:8px;">
            <button type="submit" name="add_product" class="btn">Add Product</button>
        </form>

        <h3>Existing Products</h3>
        <table>
            <tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
            <?php foreach($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td>ZMW <?= number_format($p['price'], 2) ?></td>
                <td><a href="?delete=<?= $p['id'] ?>" style="color:red;" onclick="return confirm('Delete product?')">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3 style="margin-top:50px;">Customer Orders & Payments</h3>
        <table>
            <tr><th>Order ID</th><th>Customer</th><th>Phone</th><th>Total</th><th>Method</th><th>Status</th></tr>
            <?php foreach($orders as $o): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['customer_name']) ?></td>
                <td><?= htmlspecialchars($o['phone_number']) ?></td>
                <td>ZMW <?= number_format($o['total_amount'], 2) ?></td>
                <td><?= strtoupper($o['payment_method']) ?></td>
                <td><span style="color:<?= $o['payment_status']=='Successful'?'green':'orange' ?>"><?= $o['payment_status'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
