<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function ConnectToDB()
{
	require_once realpath(dirname(__FILE__)). '/config.php';
	$conn = new mysqli(constant("DB_HOST"), constant("DB_USER"), constant("DB_PASSWORD"), constant("DB_NAME"));
	return $conn;
}

function sqlRequest($sql){
	$response = ConnectToDB()->query($sql);
    $result = [];
	if(is_object($response) && count(array($response)) > 0){
		while($row = mysqli_fetch_assoc($response))
		{
			$result[] = $row;
		}
		return $result;
	}
    return $response;
}