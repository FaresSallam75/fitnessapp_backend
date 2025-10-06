<?php
include "../../connect.php";

$sender = filterRequest(requestname: "sender");
$reciever = filterRequest(requestname: "reciever");
$message = filterRequest(requestname: "message");
$file = imageUpload(dir: "../upload/chats", imageRequest: "file");

if ($file == "fail" || $file == "empty") {
    $data = array(
        "sender" => $sender,
        "reciever" => $reciever,
        "message" => $message,

    );
} else {
    $data = array(
        "sender" => $sender,
        "reciever" => $reciever,
        "message" => $message,
        "file" => $file
    );
}

// if ($file == "fail") {
//     printFailure(message: "File Error");
// } elseif ($file == "empty") {
//     $file = null;
// } elseif ($file == "EXT") {
//     printFailure(message: "File Extension Error");
// } elseif ($file == "size") {
//     printFailure(message: "File Size Error");
// } else {
//     $data = array(
//         "sender" => $sender,
//         "receiver" => $receiver,
//         "text" => $message,
//         "file" => $file
//     );
// }


insertData(table: "chats", data: $data, json: true);
sendFCMMessage(
    title: "Hello User",
    messageBody: "This From Fitness App",
    topic: "fares",
    userId: $sender,
    pageId: "1",
    pageName: "chat"
);

?>