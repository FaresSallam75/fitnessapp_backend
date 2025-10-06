<?php
include "../../connect.php";

$name = filterRequest("name");

$data = array(
    "departmentname" => $name
);

insertData(
    table: "departments",
    data: $data,
    json: true
);



?>