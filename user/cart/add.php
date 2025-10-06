<?php
include "../../connect.php";
$userId = filterRequest(requestname: "userId");
$vegtableId = filterRequest(requestname: "vegtableId");
$name = filterRequest(requestname: "name");
$unitPrice = filterRequest(requestname: "unitPrice");
$unitCalories = filterRequest(requestname: "calories"); // ← السعرات للوحدة الواحدة
$quantity = filterRequest(requestname: "quantity");
$image = filterRequest(requestname: "image");

// check if item already exists
$stmt = $con->prepare("SELECT * FROM cart WHERE userId = ? AND vegtableId = ? LIMIT 1");
$stmt->execute([$userId, $vegtableId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
    // item exists → update quantity, price, and calories
    $newQty = $item['quantity'] + $quantity;
    $newPrice = $item['unitPrice'] * $newQty; // استخدم unitPrice من الجدول
    $newCalories = $item['unitCalories'] * $newQty; // السعرات الكلية

    $update = $con->prepare("UPDATE cart SET quantity = ?, price = ?, calories = ? WHERE cartid = ?");
    $update->execute([$newQty, $newPrice, $newCalories, $item['cartid']]);

    $data = array(
        "quantity" => $newQty,
        "price" => $newPrice,
        "calories" => $newCalories
    );

    echo json_encode([
        "status" => "success",
        "data" => $data,
    ]);

} else {
    // item does not exist → insert new
    $data = array(
        "userId" => $userId,
        "vegtableId" => $vegtableId,
        "name" => $name,
        "unitPrice" => $unitPrice,
        "unitCalories" => $unitCalories,         // ← سعرات للوحدة
        "quantity" => $quantity,
        "price" => $unitPrice * $quantity,
        "calories" => $unitCalories * $quantity, // ← سعرات كلية
        "image" => $image
    );

    insertData(
        table: "cart",
        data: $data,
        json: true
    );
}
?>