
<?php 

include "../../connect.php" ;

 $name = filterRequest(requestname: "name");
 $count = filterRequest(requestname: "count");
 $price = filterRequest(requestname: "price");
 $adminId = filterRequest(requestname: "adminId");

 $data = array( 
    "name" =>$name, 
    "count" => $count, 
    "price" => $price , 
    "adminId" => $adminId

 ); 

 insertData(table: "exports", data: $data , json: true ) ;
 


?>