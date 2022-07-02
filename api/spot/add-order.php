<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    $body = json_decode(file_get_contents('php://input'));

    $key = $body->key;
    $amount = $body->amount;
    $currencyPrice = $body->price;
    $userId = $body->userId;
    $orderDate = date('Y-m-d');

    $sql = "INSERT INTO spot_orders (`key`, `amount`,  `currency_price`, `user_id`, `order_date`) VALUES ('$key', '$amount', '$currencyPrice', '$userId', '$orderDate');";
    $request = sqlRequest($sql);
    if($request == '1'){
        $response = array(
            "status" => "OK"
        );
    } else {
        $response = array(
            "status" => "Error"
        );
    }
    print_r($response);

}