<?php
session_start();
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];

// Product ophalen uit database
$stmt = $pdo->prepare("SELECT product_id, price FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product){
    echo json_encode(["error" => "Product not found"]);
    exit;
}

// Cart aanmaken als die nog niet bestaat
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// Product toevoegen
$_SESSION['cart'][] = $product;

echo json_encode(["success" => true, "cart" => $_SESSION['cart']]);