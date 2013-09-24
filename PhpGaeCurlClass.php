<?php

require 'constants.php';
require 'functions.php';

class PhpGaeCurl
{
    private $context = array();
    private $header = array();
    private $include_header = FALSE;
    private $cookie = '';
    private $method = 'GET';
    private $connection_protocol = '';
    private $url = '';
    private $data = '';
    
    private static $defined_constants = array();
    private static $phpGaeCurl;

    public function get_context() {
        return $this->context;
    }

    public function set_context($context) {
        $this->context = $context;
    }
    
    public function get_include_header() {
        return $this->include_header;
    }

    public function set_include_header($include_header) {
        $this->include_header = $include_header;
    }

    public function get_header() {
        return $this->header;
    }

    public function set_header($header) {
        $this->header = $header;
    }

    public function get_cookie() {
        return $this->cookie;
    }

    public function set_cookie($cookie) {
        $this->cookie = $cookie;
    }

    public function get_method() {
        return $this->method;
    }

    public function set_method($method)
    {
        $this->method = $method;
    }

    public function get_connection_protocol() {
        return $this->connection_protocol;
    }

    public function set_connection_protocol($connection_protocol) {
        $this->connection_protocol = $connection_protocol;
    }

    public function get_url() {
        return $this->url;
    }

    public function set_url($url) {
        $this->url = $url;
    }

    public function get_data() {
        return $this->data;
    }

    public function set_data($data) {
        $this->data = $data;
    }

    private function __construct() { }
    
    public static function curl_init($url = '')
    {
        if (self::$phpGaeCurl === null)
            self::$phpGaeCurl = new PhpGaeCurl();
        
        if ($url !== '')
            self::$phpGaeCurl->url = $url;
        
        if (self::$defined_constants == null)
        {
            $constants = get_defined_constants();
            foreach ($constants as $key => $value)
            {
                if (strpos($key, 'CURLOPT_') === 0)
                {
                    self::$defined_constants[$value] = $key;
                }
            }
        }
        
        return self::$phpGaeCurl;
    }
    
    private function validate_constant_name($option_value)
    {
        if (!is_numeric($option_value))
            return FALSE;
        if (!isset(self::$defined_constants[$option_value]))
            return FALSE;
        return TRUE;
    }
    
    private function get_function_name($option_value)
    {
        if (!is_numeric($option_value))
            return FALSE;
        return strtolower(self::$defined_constants[$option_value]) . '_handler';
    }
    
    public function curl_close(PhpGaeCurl $phpGaeCurl = null)
    {
        self::$phpGaeCurl = null;
    }
    
    public function curl_exec(PhpGaeCurl $phpGaeCurl = null)
    {
        if ($phpGaeCurl === null)
        {
            var_dump('Set options befor!!!');
            return FALSE;
        }
        if ( ! $this->verifyUrl($phpGaeCurl->url))
        {
            var_dump('URL is not valid!!!');
            return FALSE;
        }
        
        $this->context = $this->create_context();
        
        return file_get_contents($this->url, false, $this->context);
    }
    
    public function curl_setopt(PhpGaeCurl $phpGaeCurl, $option_name, $option_value)
    {
        if ( !isset($phpGaeCurl) OR !isset($option_name) OR !isset($option_value))
            return FALSE;
        
        if ($this->validate_constant_name($option_name))
        {
            $function_name = $this->get_function_name($option_name);
            $function_name($phpGaeCurl, $option_value);
        }
    }
    
    private function constructHeader()
    {
        $header = '';
        if ($this->include_header)
            $header = implode(', ',$this->header) . ', ' . $this->cookie;
        else $header = $this->cookie;
        
        return $header;
    }

    private function verifyUrl($url = '')
    {
        if ($url === null OR $url === '')
            return FALSE;
        
        return TRUE;
    }
    
    private function create_context()
    {
        if ($this->connection_protocol === '') $this->connection_protocol = 'http';
        
        return stream_context_create(
            array(
                $this->connection_protocol =>
                array(
                    'method' => $this->method,
                    'header' => $this->constructHeader(),
                    'content' => http_build_query($this->data)
                )
            )
        );
    }
}
