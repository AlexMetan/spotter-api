<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    $body = json_decode(file_get_contents('php://input'));

    $userId = $body->userId;
    $sql = "SELECT `currency`, `key` FROM currency_pair;";
    $currencies = sqlRequest($sql);

    $sql = "SELECT `key`, `amount` FROM spot_orders WHERE user_id = '$userId';";
    $orders = sqlRequest($sql);
    if(is_array($currencies) && count($currencies) != 0){
        $response = json_encode(array(
            'status' => 'OK',
            'orders' =>  transformItemsArray($currencies, $orders)
            )
        );

    } else{
        $response = json_encode(array(
            'status' => 'No items'
        ));
    }
    print_r($response);

}

function transformItemsArray($currencies, $orders){
    for ($i = 0; $i < count($currencies); $i++){
        $currencies[$i]['amount'] = 0;
    }

    foreach($orders as $arr){
        for($i = 0; $i < count($currencies); $i++){
            if($currencies[$i]['key'] == $arr['key']){
                $currencies[$i]['amount'] += floatval($currencies[$i]['amount']) + floatval($arr['amount']);
            }
        }  
    }
    return $currencies;
}
