<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    $body = json_decode(file_get_contents('php://input'));

    $userId = $body->userId;
    $token = $body->token;

    $sql = "SELECT user_id, user_login from users WHERE token = '$token'";
    $request = sqlRequest($sql);

    if(is_array($request) && count($request) != 0){
        if($request[0]['user_id'] == $userId){
            $response = json_encode(array(
                'status' => 'OK',
                'user_login' => $request[0]['user_login']
            ));
        }
        else {
            $response = json_encode(array(
                'status' => 'Error'
            ));
        }
    }
    print_r($response);
}
