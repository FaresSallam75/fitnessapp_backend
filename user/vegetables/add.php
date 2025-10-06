<?php
include "../../connect.php";

$name = filterRequest(requestname: "name");
$calories = filterRequest(requestname: "calories");
$image = imageUpload(dir: "../upload/vegetables/", imageRequest: "image");
$departmentId = filterRequest(requestname: "departmentId");

$data = array(
    "vegetablename" => $name,
    "vegetablecalories" => $calories,
    "vegetableimage" => $image,
    "departmentId" => $departmentId,

);

insertData(
    table: "vegetables",
    data: $data,
    json: true
);



?>