<?php
// $dsn = "mysql:host=localhost;dbname=fitnessdb";
// $user = "root";
// $pass = "";
// $option = array(
//    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
// );
// $dsn = "mysql:host=sql101.infinityfree.com;dbname=if0_39825682_fitnessdb";
// $user = "if0_39825682";
// $pass = "FQr1LCBb0x2Bl";
// $option = array(
//    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
// );

$dsn = "mysql:host=tramway.proxy.rlwy.net;port=29750;dbname=railway";
$user = "root";
$pass = "railway"; // ضع كلمة المرور كما تظهر في صفحة Railway
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
);

$countrowinpage = 9;
try {
   $con = new PDO($dsn, $user, $pass, $option);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
   header("Access-Control-Allow-Methods: POST, OPTIONS , GET");
   include "functions.php";
   // if (!isset($notAuth)) {
   //    checkAuthenticate();
   // }


} catch (PDOException $e) {
   echo $e->getMessage();
}

