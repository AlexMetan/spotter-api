<?php 
function generateString($strLength) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $randString = array();
    $alphaLength = strlen($alphabet) - 1; 
    for ($i = 0; $i < $strLength; $i++) {
        $n = rand(0, $alphaLength);
        $randString[] = $alphabet[$n];
    }
    return implode($randString);
}