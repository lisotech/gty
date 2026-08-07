<?php
require_once 'config.php';
$order_id = $_GET['order_id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    die("Invalid Order ID.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status - Lisotech Store</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container" style="text-align: center; margin-top: 50px;">
        <h2>Payment Processing</h2>
        <p>Please authorize the payment prompt sent to your phone: <strong><?= htmlspecialchars($order['phone_number']) ?></strong></p>
        <p>Total Amount: <strong>ZMW <?= number_format($order['total_amount'], 2) ?></strong></p>
        <div id="status-box">
            <p>Current Status: <span id="payment-status" style="font-weight: bold; color: orange;"><?= $order['payment_status'] ?></span></p>
        </div>
        <br>
        <a href="index.php" class="btn" id="return-home" style="display:none;">Return to Home</a>
    </div>

    <script>
        const orderId = <?= $order_id ?>;
        const checkInterval = setInterval(() => {
            fetch(`api/check_status.php?order_id=${orderId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('payment-status').innerText = data.status;
                    if(data.status === 'Successful') {
                        document.getElementById('payment-status').style.color = 'green';
                        document.getElementById('return-home').style.display = 'inline-block';
                        clearInterval(checkInterval);
                        localStorage.removeItem('cart'); // Clear cart
                    } else if(data.status === 'Failed') {
                        document.getElementById('payment-status').style.color = 'red';
                        clearInterval(checkInterval);
                    }
                });
        }, 3000);
    </script>
</body>
</html>
