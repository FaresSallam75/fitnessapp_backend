<?php
include "../connect.php"; 
  
 $userId = filterRequest(requestname: "userId") ; 

 getAllData(table: "payment" , where: "userId = ?" , values: [$userId], json: true) ; 




?>