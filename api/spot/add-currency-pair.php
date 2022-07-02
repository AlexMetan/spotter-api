<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    require_once realpath(dirname(__FILE__)).'/../common/random-string.php';

    $body = json_decode(file_get_contents('php://input'));

    $userId = $body->userId;
    $currency = $body->currency;
    $key = generateString(25);

    $sql = "INSERT INTO spot_orders (`key`, `currency`, `user_id`) VALUES ('$key', '$currency', '$userId' );";

    $request = sqlRequest($sql);
    
    print_r($request);
}
