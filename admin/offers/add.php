<?php
include "../../connect.php";

$name = filterRequest(requestname: "name");
$period = filterRequest(requestname: "period");
$price = filterRequest(requestname: "price");
$file = imageUpload(dir: "../../upload/offers" , imageRequest: "file" );
    if ($file == "fail" || $file == "empty") {
    $data = array(
        "name" => $name,
        "period" => $period,
        "price" => $price,  
    );
} else {
     $data = array(
        "name" => $name,
        "period" => $period,
        "price" => $price,  
        "image" => $file,
    );
}
    insertData(table: "offers", data: $data, json: true);


?>