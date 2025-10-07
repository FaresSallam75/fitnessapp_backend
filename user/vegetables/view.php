<?php
include "../../connect.php";

  
// $statement = $con->prepare("SELECT  vegetables.*, departments.* FROM vegetables, departments 
// WHERE vegetables.departmentid = departments.departmentid") ;  
//    $statement->execute(array()) ; 
//    $data = $statement->fetchAll(PDO::FETCH_ASSOC) ; 
//    $count = $statement->rowCount() ; 
//    if($count >0){
//     echo json_encode(array("status"=>"success", "data" =>$data)) ;
// } else{ 
//        echo json_encode(array("status"=>"failure")) ;
//    }


getAllData(
    table: "vegetables, departments",
    where: "vegetables.departmentid = departments.departmentid",
    values: array(),
    json: true
);

?>