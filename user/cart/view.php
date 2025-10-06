<?php
include "../../connect.php";

$userId = filterRequest(requestname: "userId");

getAllData(table: "cartview", where: "userId = ?", values: [$userId], json: true);




?>