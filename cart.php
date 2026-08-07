<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Lisotech Store</title>
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
        <h2>Your Shopping Cart</h2>
        <div id="cart-items"></div>
        <div id="cart-summary" style="display:none;">
            <h3>Total: ZMW <span id="cart-total">0.00</span></h3>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        </div>
    </div>

    <script src="assets/script.js"></script>
    <script>renderCartPage();</script>
</body>
</html>
