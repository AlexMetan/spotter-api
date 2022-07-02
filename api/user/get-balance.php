<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    require_once realpath(dirname(__FILE__)).'/../common/random-string.php';

    $body = json_decode(file_get_contents('php://input'));

    $userId = $body->userId;
    $token = $body->token;
    
    $sql = "SELECT balance from users WHERE `user_id` = '$userId' AND `token` = '$token';";
    $request = sqlRequest($sql);
    if(!empty($request)){
        $response = json_encode(array(
            'status' => 'OK',
            'balance' => $request[0]['balance']
        ));
    } else {
        $response = json_encode(array(
            'status' => 'Error'
        ));
    }
    
    print_r($response);
}