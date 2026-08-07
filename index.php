<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
$featured_products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisotech Store - Home</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="logo">Lisotech Store</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart (<span id="cart-count">0</span>)</a>
            <a href="admin/login.php">Admin</a>
        </nav>
    </header>

    <section class="hero">
        <h1>Innovative Tech & Digital Solutions</h1>
        <p>Shop top-quality products with instant Mobile Money checkout.</p>
        <a href="products.php" class="btn">Explore Catalog</a>
    </section>

    <section class="container">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php foreach($featured_products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p>ZMW <?= number_format($product['price'], 2) ?></p>
                    <button class="btn" onclick='addToCart(<?= json_encode($product) ?>)'>Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <script src="assets/script.js"></script>
</body>
</html>
