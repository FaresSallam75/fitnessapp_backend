<?php


include "../../connect.php";

$name = filterRequest(requestname: "name");
$email = filterRequest(requestname: "email");
$password = filterRequest(requestname: "password");
$hashedPassword = password_hash(password: $password, algo: PASSWORD_BCRYPT);
$phone = filterRequest(requestname: "phone");
$gender = filterRequest(requestname: "gender");
$age = filterRequest(requestname: "age");
$twon = filterRequest(requestname: "twon");
$file = imageUpload(dir: "../../upload/coaches" , imageRequest: "file" );

$stmt = $con->prepare(query: "SELECT * FROM `coaches` WHERE email = ? ");
$stmt->execute(params: array($email));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure(message: "EMAIL IS EXISTED");
} else {
    if ($file == "fail" || $file == "empty") {
    $data = array(
        "name" => $name,
        "email" => $email,
        "password" => $hashedPassword,
        "phone" => $phone,
        "gender" => $gender,
        "age" => $age,
        "twon" => $twon,   
    );
} else {
     $data = array(
        "name" => $name,
        "email" => $email,
        "password" => $hashedPassword,
        "phone" => $phone,
        "gender" => $gender,
        "age" => $age,
        "twon" => $twon,
        "image" => $file,
    );
}
    insertData(table: "coaches", data: $data, json: true);
} 



?>