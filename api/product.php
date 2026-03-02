<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once 'config/database.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// set product id property of record to read
$id = isset($_GET['id']) ? $_GET['id'] : die();

// query product
$query = "SELECT 
            p.product_id, p.name, p.description, p.price, p.kcal, p.available,
            c.name as category_name,
            i.filename as image_filename
          FROM products p
          LEFT JOIN categories c ON p.category_id = c.category_id
          LEFT JOIN images i ON p.image_id = i.image_id
          WHERE p.product_id = ?
          LIMIT 0,1";

// prepare query statement
$stmt = $db->prepare($query);

// bind id of product to be updated
$stmt->bindParam(1, $id);

// execute query
$stmt->execute();

// get retrieved row
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // create array
    $product_item = array(
        "id" => $row['product_id'],
        "name" => $row['name'],
        "description" => html_entity_decode($row['description']),
        "price" => (float) $row['price'],
        "kcal" => $row['kcal'],
        "available" => $row['available'],
        "category" => $row['category_name'],
        "image" => $row['image_filename']
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($product_item);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Product does not exist."));
}
?>