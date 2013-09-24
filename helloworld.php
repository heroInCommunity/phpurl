<?php

    include 'PhpGaeCurl.php';
    
    $phpGaeCurl = curl_init('http://football.ua/');
    curl_setopt($phpGaeCurl, CURLOPT_HEADER, true);
    curl_setopt($phpGaeCurl, CURLOPT_HTTPHEADER, 'Content-type: text/html');
    curl_setopt($phpGaeCurl, CURLOPT_POSTFIELDS, array('apple' => 'cool', 'orange' => 'better'));
    curl_setopt($phpGaeCurl, CURLOPT_HTTPGET, TRUE);
    
    $result = curl_exec($phpGaeCurl);
    
    //var_dump($result);



