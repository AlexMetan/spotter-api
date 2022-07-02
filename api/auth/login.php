<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    require_once realpath(dirname(__FILE__)).'/../common/random-string.php';

    $body = json_decode(file_get_contents('php://input'));

    $login = $body->login;
    $password = $body->password;
    $passMD5 = md5($password);

    $sql = "SELECT user_id FROM users WHERE user_login = '$login' AND user_password = '$passMD5'; ";
    $request = sqlRequest($sql);

    if($request[0]!=null){
        $token = generateString(25);
        $userId = $request[0]['user_id'];
        $sql = "UPDATE users SET token = '$token' WHERE user_id = '$userId';";
        $updateRequest = sqlRequest($sql);
   
        $response = json_encode(array(
            'status'  => 'OK',
            'user_id' => $userId,
            'token' => $token
        ));

    } else{
        $response = json_encode(array(
            'status'  => 'Error'
        ));
    }
    print_r($response);
}

