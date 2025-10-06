<?php

include "../connect.php";

// $email = filterRequest(requestname: "email");
// $password = filterRequest(requestname: "password"); 
// $stmt = $con->prepare(query: "SELECT * FROM coaches WHERE `email` = ? and `password` = ? ");
// $stmt->execute(params: array($email, $password));
// $data = $stmt->fetch(mode: PDO::FETCH_ASSOC);
// $count = $stmt->rowCount();
// if ($count  > 0 ) {
//         echo json_encode(value: array("status" => "success", "name" => "coaches", "data" => $data));
// } else {
//     echo json_encode(value: array("status" => "failure"));
// }



$email    = filterRequest("email");
$password = filterRequest("password");

// هات المستخدم حسب الايميل فقط
$stmt = $con->prepare(query: "SELECT * FROM coaches WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$data = $stmt->fetch(mode: PDO::FETCH_ASSOC);

if ($data) {
    if (password_verify($password, $data['password'])) {
        unset($data['password']); 
        echo json_encode(value: [
            "status" => "success",
            "name"   => "coaches",
            "data"   => $data
        ]);
    } else {
        echo json_encode(value: [
            "status" => "failure",
            "message"    => "Wrong password"
        ]);
    }
} else {
    echo json_encode(value: [
        "status" => "failure",
        "message"    => "Email not found"
    ]);
}
  




?>