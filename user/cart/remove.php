<?php
include "../../connect.php";

$userId = filterRequest(requestname: "userId");
$vegtableId = filterRequest(requestname: "vegtableId");

// check if item exists
$stmt = $con->prepare("SELECT * FROM cart WHERE userId = ? AND vegtableId = ? LIMIT 1");
$stmt->execute([$userId, $vegtableId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
    $currentQty = (int) $item['quantity'];

    if ($currentQty > 1) {
        // ↓ decrease quantity by 1
        $newQty = $currentQty - 1;
        $newPrice = $item['unitPrice'] * $newQty;

        $update = $con->prepare("UPDATE cart SET quantity = ?, price = ? WHERE cartid = ?");
        $update->execute([$newQty, $newPrice, $item['cartid']]);

        echo json_encode([
            "status" => "success",
            "data" => [
                "quantity" => $newQty,
                "price" => $newPrice
            ]
        ]);
    } else {
        // ↓ if quantity = 1 → remove row completely
        $delete = $con->prepare("DELETE FROM cart WHERE cartid = ?");
        $delete->execute([$item['cartid']]);

        echo json_encode([
            "status" => "success",
            "data" => "item_removed"
        ]);
    }
} else {
    echo json_encode([
        "status" => "success",
        "message" => "Item not found"
    ]);
}



?>