<?php


use Google\Auth\OAuth2;
require 'vendor/autoload.php';
define("MB", 1048576);

function filterRequest($requestname)
{
    return htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    if ($where == null) {
        $stmt = $con->prepare("SELECT  * FROM $table   ");
    } else {
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    }
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        if ($count > 0) {
            return array("status" => "success", "data" => $data);
        } else {
            return array("status" => "failure");
        }
    }
}

function getData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    } else {
        return $count;
    }
}




function insertData($table, $data, $json = true, )
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($dir, $imageRequest)
{
    global $msgError;
    if (isset($_FILES[$imageRequest])) {
        $imagename = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
        $imagetmp = $_FILES[$imageRequest]['tmp_name'];
        $imagesize = $_FILES[$imageRequest]['size'];
        $allowExt = array("jpg", "png", "gif", "mp3", "pdf", "svg");
        $strToArray = explode(".", $imagename);
        $ext = end($strToArray);
        $ext = strtolower($ext);

        if (!empty($imagename) && !in_array($ext, $allowExt)) {
            $msgError = "EXT";
        }
        if ($imagesize > 2 * MB) {
            $msgError = "size";
        }
        if (empty($msgError)) {
            move_uploaded_file($imagetmp, $dir . "/" . $imagename);
            return $imagename;
        } else {
            return "fail";
        }
    } else {
        return 'empty';
    }
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" || $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 
}


function printFailure($message = "none")
{
    echo json_encode(array("status" => "failure", "message" => $message));
}
function printSuccess($message = "none")
{
    echo json_encode(array("status" => "success", "message" => $message));
}

function result($count)
{
    if ($count > 0) {
        printSuccess();
    } else {
        printFailure();
    }
}

function sendEmail($to, $title, $body)
{
    $header = "From: support@faressallam.com " . "\n" . "CC: testtest150250@gmail.com";
    mail($to, $title, $body, $header);
}





function getAccessToken(): string
{
    $serviceAccount = json_decode(json: file_get_contents(filename: __DIR__ . '/fitnessapp.json'), associative: true);

    $oauth = new OAuth2(config: [
        'audience' => $serviceAccount['token_uri'],
        'issuer' => $serviceAccount['client_email'],
        'signingAlgorithm' => 'RS256',
        'signingKey' => $serviceAccount['private_key'],
        'tokenCredentialUri' => $serviceAccount['token_uri'],
        'scope' => [
            "https://www.googleapis.com/auth/firebase.messaging",
            "https://www.googleapis.com/auth/userinfo.email",
            "https://www.googleapis.com/auth/firebase.database"
        ],
    ]);

    $authToken = $oauth->fetchAuthToken();
    return $authToken['access_token'];
}



function sendFCMMessage(
    string $title,
    string $messageBody,
    string $topic,
    string $userId,
    string $pageId,
    string $pageName
): void {
    $accessToken = getAccessToken();
    $fcmEndpoint = 'https://fcm.googleapis.com/v1/projects/fitnessapp-5f810/messages:send';


    $message = [
        'message' => [
            'topic' => $topic,
            // 'token' => $targetToken,
            'notification' => [
                'title' => $title,
                'body' => $messageBody,
            ],
            'data' => [
                'current_user_fcm_token' => $topic,
                'userId' => $userId,
                "pageid" => $pageId,
                "pagename" => $pageName

            ],
        ],
    ];

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $fcmEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode === 200) {
        // echo "✅ FCM message sent successfully\n";
    } else {
        // echo "❌ Failed to send FCM message: HTTP $httpCode\nResponse: $response\n";
    }

    curl_close($ch);
}



function insertNotify($title, $body, $userid, $topic, $pageid, $pagename)
{
    global $con;
    $stmt = $con->prepare(query: "INSERT INTO `notification`(`notification_title`, `notification_body`, `notification_userid`) VALUES (? , ? , ?)");
    $stmt->execute(params: array($title, $body, $userid));
    sendFCMMessage(title: $title, messageBody: $body, topic: $topic, userId: $userid, pageId: $pageid, pageName: $pagename);
    $count = $stmt->rowCount();

    return $count;
}



function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}


?>