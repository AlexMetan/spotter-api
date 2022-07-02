<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    require_once realpath(dirname(__FILE__)).'/../common/random-string.php';

    $body = json_decode(file_get_contents('php://input'));

    $login = $body->login;
    $password = $body->password;
    $passMD5 = md5($password);

    $sqlSelect = "SELECT id FROM users WHERE user_login = '$login'";
    $requestSelect = sqlRequest($sqlSelect);
    if(is_array($requestSelect) && count($requestSelect) == 0){
        $user_id = generateString(15);
        $token = generateString(15);
        $sqlInsert = "INSERT INTO users (user_id, user_login, user_password, balance, token) VALUES ('$user_id', '$login', '$passMD5', 0, '$token');";
        $requestInsert = sqlRequest($sqlInsert);
        $response = json_encode(array(
            'status' => 'OK',
            'user_id' => $user_id,
            'token' => $token
        ));
    }else {
        $response = json_encode(array(
            'status' => 'User already exists'
        ));
    }
    print_r($response);
}