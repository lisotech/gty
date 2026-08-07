<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Lisotech Store</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="logo">Lisotech Store</div>
        <nav><a href="cart.php">Back to Cart</a></nav>
    </header>

    <div class="container checkout-container">
        <h2>Customer Checkout</h2>
        <form id="checkout-form">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group">
                <label>Phone Number (Mobile Money)</label>
                <input type="text" id="phone_number" name="phone_number" placeholder="26097xxxxxxxx / 26076xxxxxxxx" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Payment Provider</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="airtel">Airtel Money</option>
                    <option value="mtn">MTN MoMo</option>
                </select>
            </div>
            <button type="submit" class="btn">Pay Now via Mobile Money</button>
        </form>
    </div>
    <script src="assets/script.js"></script>
    <script>handleCheckout();</script>
</body>
</html>
