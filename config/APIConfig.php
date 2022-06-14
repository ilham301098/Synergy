<?php

function hitApi($prefix,$path,$param){
    require('dbRep.php');

	// $url=$env_base_url.'/'.$prefix.'/'.$path;
    $url='http://localhost:8000/'.$prefix.'/'.$path;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, TRUE);

    return $data;
}

function hitApiGet($path){
    require('dbRep.php');
    

    // $url=$env_base_url.'/'.$path;
    $url='http://localhost:8000/'.$path;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, TRUE);

    return $data;
}

?>