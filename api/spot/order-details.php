<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    $body = json_decode(file_get_contents('php://input'));

    $userId = $body->userId;
    $orderId = $body->orderId;

    $sql = "SELECT * FROM spot_orders WHERE `user_id` = '$userId' AND `key` = '$orderId'  AND `amount` != '0'  ORDER BY order_date ASC;";
    $request = sqlRequest($sql);

    $sql = "SELECT `currency` FROM currency_pair WHERE `key` = '$orderId';";
    $request_c = sqlRequest($sql);
    if(is_array($request) && count($request) != 0){
        $response = json_encode(array(
            'status' => 'OK',
            'currency' => $request_c[0]['currency'],
            'key' => $orderId,
            'orders' => $request
            )
        );

    } else{
        $response = json_encode(array(
            'currency' => $request_c[0]['currency'],
            'key' => $orderId,
            'status' => 'OK'
        ));
    }
    
    print_r($response);
}
