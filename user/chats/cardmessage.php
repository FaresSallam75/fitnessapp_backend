<?php

include "../../connect.php";

$userId = filterRequest(requestname: "userId");
// $doctorId = filterRequest("doctorId");

$statement = $con->prepare(query: "SELECT chats.*, users.* FROM  chats INNER JOIN users
on chats.sender = $userId
OR chats.reciever = $userId
INNER JOIN coaches 
on chats.reciever = coaches.id
GROUP BY chats.sender, chats.reciever
ORDER BY chats.chatId ASC
");

$statement->execute(array());
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();
if ($count > 0) {

    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));

}



?>