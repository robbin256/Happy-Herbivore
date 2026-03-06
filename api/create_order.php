<?php
session_start();
require 'db.php';

if(empty($_SESSION['cart'])){
    echo json_encode(["error" => "Cart is empty"]);
    exit;
}

$pdo->beginTransaction();

try {

    // 🔢 Pickup number genereren (01-99 per dag)
    $stmt = $pdo->prepare("
        SELECT MAX(pickup_number) as max_pickup
        FROM orders
        WHERE DATE(datetime) = CURDATE()
    ");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $nextPickup = $result['max_pickup'] ? intval($result['max_pickup']) + 1 : 1;
    if($nextPickup > 99) $nextPickup = 1;

    $pickup_number = str_pad($nextPickup, 2, "0", STR_PAD_LEFT);

    // 💰 Totaal berekenen
    $total = 0;
    foreach($_SESSION['cart'] as $item){
        $total += $item['price'];
    }

    // 🛒 Order aanmaken (status 2 = Placed and paid)
    $stmt = $pdo->prepare("
        INSERT INTO orders (order_status_id, pickup_number, price_total)
        VALUES (2, ?, ?)
    ");
    $stmt->execute([$pickup_number, $total]);

    $order_id = $pdo->lastInsertId();

    // 📦 Producten koppelen
    $stmt = $pdo->prepare("
        INSERT INTO order_product (order_id, product_id, price)
        VALUES (?, ?, ?)
    ");

    foreach($_SESSION['cart'] as $item){
        $stmt->execute([$order_id, $item['product_id'], $item['price']]);
    }

    $pdo->commit();

    // Cart leegmaken
    unset($_SESSION['cart']);

    echo json_encode([
        "success" => true,
        "order_id" => $order_id,
        "pickup_number" => $pickup_number
    ]);

} catch(Exception $e){
    $pdo->rollBack();
    echo json_encode(["error" => $e->getMessage()]);
}