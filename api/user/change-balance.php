<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once realpath(dirname(__FILE__)).'/../db/db-connect.php';
    require_once realpath(dirname(__FILE__)).'/../common/random-string.php';

    $body = json_decode(file_get_contents('php://input'));

    $userId = $body->userId;
    $token = $body->token;
    $amount = $body->amount;
    $type = $body->type;
    $isDeposit = $body->isDeposit;
   
    $sql = "SELECT balance from users WHERE `user_id` = '$userId' AND `token` = '$token';";
    $request = sqlRequest($sql);

    if(!empty($request)){

        $currentBalance = floatval($request[0]['balance']);
        $newBalance = $currentBalance + floatval($amount) * floatval($type); 

        $sql = "UPDATE users SET balance = '$newBalance' WHERE `user_id` = '$userId' AND `token` = '$token';";
        $request = sqlRequest($sql);

        if($request && $isDeposit){
            $depositDate = date('Y-m-d');
            $sql = "INSERT INTO deposit_history (user_id, amount, deposit_date) VALUES ('$userId', '$amount', '$depositDate');";
            $request = sqlRequest($sql);
        }

        $response = json_encode(array(
            'status' => 'OK'
        ));
        
    } else{
        $response = json_encode(array(
            'status' => 'Error'
        ));
    }
  
    print_r($response);
}