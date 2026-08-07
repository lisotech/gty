<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog - Lisotech Store</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="logo">Lisotech Store</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart (<span id="cart-count">0</span>)</a>
        </nav>
    </header>

    <div class="container">
        <h2>All Products & Services</h2>
        <div class="product-grid">
            <?php foreach($products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="desc"><?= htmlspecialchars($product['description']) ?></p>
                    <p class="price">ZMW <?= number_format($product['price'], 2) ?></p>
                    <button class="btn" onclick='addToCart(<?= json_encode($product) ?>)'>Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>
