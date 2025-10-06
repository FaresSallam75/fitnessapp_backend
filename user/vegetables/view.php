<?php
include "../../connect.php";

getAllData(
    table: "vegetables, departments",
    where: "vegetables.departmentid = departments.departmentid",
    values: array(),
    json: true
);

// getAllData(
//     table: "veg_dep_view",
//     where: "1 = 1",
//     values: array(),
//     json: true
// );

?>