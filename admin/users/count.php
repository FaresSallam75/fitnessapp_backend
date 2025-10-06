

<?php
include "../../connect.php" ; 

$statement = $con->prepare(query: "SELECT Count(*) as countUsers FROM `users` " ) ; 
$statement->execute() ; 
$data =  $statement->fetch(PDO::FETCH_ASSOC) ;
$count = $statement->rowCount() ; 
  if($count > 0){
  echo json_encode(array("status" => "success", "data" => $data));
} else{ 
    echo json_encode(value: array("status" => "failure"));
  }


?>