<!-- <?php
include "../connect.php";

$coacheName = filterRequest(requestname: "coacheName");
$coacheEmail = filterRequest(requestname: "coacheEmail");
$coachpassword = sha1(string: $_POST['coachePassword']);
$coachePhone = filterRequest(requestname: "coachePhone");
$coacheImage = filterRequest(requestname: "coacheImage");


$stmt = $con->prepare(query: "SELECT * FROM `coaches` WHERE coacheEmail = ? ");
$stmt->execute(params: array($coacheEmail));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure(message: "EMAIL IS EXISTED");
} else {


    $data = array(
        "coacheName" => $coacheName,
        "coacheEmail" => $coacheEmail,
        "coachePassword" => $coachpassword,
        "coachePhone" => $coachePhone,
        "coacheImage" => $coacheImage,
    );
    //sendEmail($email , "Verfiy Code Ecommerce" , "Verfiy Code $verfiycode") ; 
    insertData(table: "coaches", data: $data, json: true);


}



?> -->