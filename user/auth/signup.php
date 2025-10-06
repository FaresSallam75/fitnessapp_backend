<?php

include "../../connect.php";

$name = filterRequest("name");
$email = filterRequest("email");
$password = sha1($_POST['password']);

$stmt = $con->prepare("SELECT * FROM `users` WHERE email = ? ");
$stmt->execute(array($email));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure("EMAIL IS EXISTED");
} else {
    $data = array(
        "name" => $name,
        "email" => $email,
        "password" => $password,
    );
    //sendEmail($email , "Verfiy Code Ecommerce" , "Verfiy Code $verfiycode") ; 
    insertData("users", $data);

}

?>