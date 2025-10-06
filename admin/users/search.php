
<?php
 include "../../connect.php" ; 
  
 $search = filterRequest(requestname: "search");

//  $data = array(
//     "name" => $search
//  ); 

 getAllData(table: "users", 
     where: "name like '%$search%' " , 
     values: null , 
     json: true
 )



?>