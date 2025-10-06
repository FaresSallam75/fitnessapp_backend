<?php
include "../../connect.php";
$sender = filterRequest(requestname: "sender");
$reciever = filterRequest(requestname: "reciever");
 

getAllData(
    table: "chatview",
    where: "sender = $sender AND reciever = $reciever OR reciever = $sender AND sender = $reciever ORDER BY dateTime DESC ",
    values: null,
    json: true, 
);


?>