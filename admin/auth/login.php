<?php

include "../../connect.php";

$email = filterRequest(requestname: "email");
// $password = sha1(string: $_POST['password']);
$password = password_hash(password: "password", algo: PASSWORD_BCRYPT);

$stmt = $con->prepare(query: "SELECT * FROM admin WHERE `email` = ? or `password` = ? ");
$stmt->execute(params: array($email, $password));
$data = $stmt->fetch(mode: PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
if ($count > 0) {
    echo json_encode(value: array("status" => "success", "data" => $data));
} else {
    echo json_encode(value: array("status" => "failure"));
}


?>