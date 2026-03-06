<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once 'config/database.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// query products
$query = "SELECT 
            p.product_id, p.name, p.description, p.price, p.kcal, p.available,
            c.name as category_name,
            i.filename as image_filename
          FROM products p
          LEFT JOIN categories c ON p.category_id = c.category_id
          LEFT JOIN images i ON p.image_id = i.image_id
          WHERE p.available = 1
          ORDER BY c.name, p.name";

$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product_item = array(
            "id" => $product_id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => (float) $price,
            "kcal" => $kcal,
            "available" => $available,
            "category" => $category_name,
            "image" => $image_filename
        );
        array_push($products_arr["records"], $product_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($products_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(array("message" => "No products found."));
}
?>