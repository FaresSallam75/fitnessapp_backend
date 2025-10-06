<?php
  
  include "../../connect.php" ;
   
  $userId = filterRequest(requestname: "userId") ;
  $adminId = filterRequest(requestname: "adminId") ;
  $price = filterRequest(requestname: "price") ;
  $startDate = filterRequest(requestname: "startDate") ;
  $endDate = filterRequest(requestname: "endDate") ;
  $type = filterRequest(requestname: "type") ; // cash - visa .. 

   $statement = $con->prepare("SELECT * FROM `payment` WHERE userId = ? AND status = 1 ") ;
    $statement->execute(array($userId)) ;
    $count = $statement->rowCount() ;
    if($count > 0 ){
        // updateData(table: "payment" ,  data: array("status" => 0) , where: "userId = $userId AND status = 1 " , json: false);
        printFailure(message: "USER IS PAID BEFORE") ;
        exit() ; 
    } else{ 
  $data =  array(
    "userId" =>  $userId , 
    "adminId" =>  $adminId , 
    "price" =>  $price , 
    "startDate" =>  $startDate ,
    "endDate" => $endDate , 
    "type" => $type , 
    "status" => "1" , 
  );

  insertData(table: "payment" ,  data: $data , json: true);
 
    }





?>