<?php

require 'PhpGaeCurlClass.php';

function curl_init($url = '')
{
    return PhpGaeCurl::curl_init($url);
}

function curl_exec(PhpGaeCurl $phpGaeCurl = null)
{
    if ($phpGaeCurl === null OR ! $phpGaeCurl instanceof PhpGaeCurl)
        return FALSE;
    return $phpGaeCurl->curl_exec($phpGaeCurl);
}

function curl_setopt(PhpGaeCurl $phpGaeCurl = null, $option_name = '', $option_value = '')
{
    if ($phpGaeCurl === null OR ! $phpGaeCurl instanceof PhpGaeCurl)
        return FALSE;
    $phpGaeCurl->curl_setopt($phpGaeCurl, $option_name, $option_value);
}

function curl_close(PhpGaeCurl $phpGaeCurl = null)
{
    if ($phpGaeCurl === null OR ! $phpGaeCurl instanceof PhpGaeCurl)
        return FALSE;
     return $phpGaeCurl->curl_close($phpGaeCurl);
}