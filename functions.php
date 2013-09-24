<?php

function curlopt_url_handler($phpGaeCurl, $option_value)
{
    if (is_string($option_value))
        $phpGaeCurl->set_url($option_value);
}

function curlopt_header_handler($phpGaeCurl, $option_value)
{
    if (is_bool($option_value))
        $phpGaeCurl->set_include_header($option_value);
}

function curlopt_httpheader_handler($phpGaeCurl, $option_value)
{
    if (is_array($option_value))
            $phpGaeCurl->set_header($option_value);
}

function curlopt_postfields_handler($phpGaeCurl, $option_value)
{
    if ( !is_array($option_value))
    {
        $phpGaeCurl->set_data(array($option_value));
        set_content_type($phpGaeCurl, 'application/x-www-form-urlencoded');
    }
    else
    {
                //var_dump($phpGaeCurl->get_header());
        $phpGaeCurl->set_data($option_value);
        if ($phpGaeCurl->get_header() !== null && is_array($phpGaeCurl->get_header()))
            set_content_type($phpGaeCurl, 'multipart/form-data');
    }
}

function curlopt_post_handler($phpGaeCurl, $option_value)
{
    if ($option_value === TRUE OR $option_value == 1)
    {
        $phpGaeCurl->set_method('POST');
        set_content_type($phpGaeCurl, 'application/x-www-form-urlencoded');
    }
}

function curlopt_httpget_handler($phpGaeCurl, $option_value)
{
   if ($option_value === TRUE OR $option_value == 1)
        $phpGaeCurl->set_method('GET');
}

function curlopt_put_handler($phpGaeCurl, $option_value)
{
    if ($option_value === TRUE OR $option_value == 1)
        $phpGaeCurl->set_method('PUT');
}

function curlopt_customrequest_handler($phpGaeCurl, $option_value)
{
    if (validCustomRequest($option_value))
        $phpGaeCurl->set_method($option_value);
}

function set_content_type(PhpGaeCurl $phpGaeCurl, $content_type = '')
{
    if ($content_type == '')
        return;

    $header = $phpGaeCurl->get_header();
    if ($header)
    {
        foreach ($header as $key => $value)
        {
            if (strpos($value, 'Content-type') === 0)
            {
                $header[$key] = 'Content-type: ' . $content_type;
            }
        }
    }
    else $header[] = 'Content-type: ' . $content_type;

    $phpGaeCurl->set_header($header);
            
    return;
}

function validCustomRequest($optionValue = '')
{
    //ToDo is I really need this?
    //if ($optionValue !== 'GET' OR $optionValue !== 'DELETE' OR $optionValue !== 'PUT' OR $optionValue !== 'POST' OR
    //        $optionValue !== 'CONNECT' OR $optionValue !== 'HEAD')
    //    return FALSE;

    return TRUE;
}