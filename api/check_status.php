<?php
require_once '../config.php';
header('Content-Type: application/json');

$order_id = $_GET['order_id'] ?? 0;
$stmt = $pdo->prepare("SELECT payment_status FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

// For simulation purposes, automatically transition Pending to Successful after a check loop
if ($order && $order['payment_status'] === 'Pending') {
    // In production, query MTN/Airtel API transaction status here.
    // For demo flow, we update to Successful automatically via simulation logic:
    $upd = $pdo->prepare("UPDATE orders SET payment_status = 'Successful', transaction_id = ? WHERE id = ?");
    $upd->execute(['SIM_TXN_' . rand(100000, 999999), $order_id]);
    $order['payment_status'] = 'Successful';
}

echo json_encode(['status' => $order ? $order['payment_status'] : 'Not Found']);
?>
