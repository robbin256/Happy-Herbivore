<?php
header("Content-Type: application/json");

// db.php correct includen
require __DIR__ . '/config/database.php';

// Database verbinding maken via class
$database = new Database();
$pdo = $database->getConnection();

// JSON cart ontvangen van fetch
$input = json_decode(file_get_contents("php://input"), true);

if(empty($input['items'])){
    echo json_encode(["error"=>"Cart is empty"]);
    exit;
}

$cart = $input['items'];

try {

    $pdo->beginTransaction();

    // 🔢 Pickup number genereren (01-99 per dag)
    $stmt = $pdo->prepare("
        SELECT MAX(pickup_number) as max_pickup
        FROM orders
        WHERE DATE(datetime) = CURDATE()
    ");
    $stmt->execute();
    $result = $stmt->fetch();

    $nextPickup = $result['max_pickup'] ? intval($result['max_pickup']) + 1 : 1;
    if($nextPickup > 99) $nextPickup = 1;

    $pickup_number = str_pad($nextPickup, 2, "0", STR_PAD_LEFT);

    // 💰 Totaal berekenen
    $total = 0;
    foreach($cart as $item){
        $total += $item['price'] * $item['quantity'];
    }

    // 🛒 Order aanmaken (status 2 = Placed and paid)
    $stmt = $pdo->prepare("
        INSERT INTO orders (order_status_id, pickup_number, price_total)
        VALUES (2, ?, ?)
    ");
    $stmt->execute([$pickup_number, $total]);

    $order_id = $pdo->lastInsertId();

    // 📦 Producten koppelen met quantity
    $stmt = $pdo->prepare("
        INSERT INTO order_product (order_id, product_id, price, quantity)
        VALUES (?, ?, ?, ?)
    ");

    foreach($cart as $item){
        $stmt->execute([$order_id, $item['id'], $item['price'], $item['quantity']]);
    }

    $pdo->commit();

    // ✅ Response teruggeven
    echo json_encode([
        "success" => true,
        "order_id" => $order_id,
        "pickup_number" => $pickup_number
    ]);

} catch(Exception $e){
    $pdo->rollBack();
    echo json_encode(["error" => $e->getMessage()]);
}