<?php

include "../../connect.php";

$name = filterRequest("name");
$email = filterRequest("email");
// $password = sha1($_POST['password']);
$password = password_hash(password: "password", algo: PASSWORD_BCRYPT);
$phone = filterRequest("phone");

$stmt = $con->prepare("SELECT * FROM `admin` WHERE email = ? ");
$stmt->execute(array($email));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure("EMAIL IS EXISTED");
} else {
    $data = array(
        "name" => $name,
        "email" => $email,
        "password" => $password,
        "phone" => $phone,
    );
    //sendEmail($email , "Verfiy Code Ecommerce" , "Verfiy Code $verfiycode") ; 
    insertData("admin", $data);

}

?>