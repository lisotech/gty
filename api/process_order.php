<?php
require_once '../config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['customer_name']) && !empty($data['phone_number']) && !empty($data['cart'])) {
    try {
        $pdo->beginTransaction();

        $total = 0;
        foreach($data['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Insert Order
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, phone_number, email, total_amount, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
        $stmt->execute([
            htmlspecialchars($data['customer_name']),
            htmlspecialchars($data['phone_number']),
            htmlspecialchars($data['email']),
            $total,
            htmlspecialchars($data['payment_method'])
        ]);
        
        $order_id = $pdo->lastInsertId();

        // Insert Order Items
        $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach($data['cart'] as $item) {
            $itemStmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
        }

        $pdo->commit();

        // SIMULATE PAYMENT GATEWAY REQUEST (Airtel/MTN APIs)
        // In production, integrate cURL requests to official Airtel/MTN collection APIs here.
        
        echo json_encode(['success' => true, 'order_id' => $order_id]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data payload.']);
}
?>
