<?php

include '../PhpGaeCurl.php';

class PhpGaeCurlTest extends PHPUnit_Framework_TestCase
{
    private $phpGaeCurl = null;

    protected function setUp()
    {
        $this->phpGaeCurl = curl_init('http://football.ua/');
    }
    
    protected function tearDown()
    {
        curl_close($this->phpGaeCurl);
        $this->phpGaeCurl = curl_init('http://football.ua/');
    }
    
    public function testCurl_setopt()
    {
        curl_setopt($this->phpGaeCurl, CURLOPT_HTTPHEADER, array('f'));
        $this->assertContains('f', $this->phpGaeCurl->get_header());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_HTTPHEADER, array('Content-type: text/html'));
        $this->assertContains('Content-type: text/html', $this->phpGaeCurl->get_header());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_POSTFIELDS, array('apple' => 'cool', 'orange' => 'better'));
        $this->assertContains('Content-type: multipart/form-data', $this->phpGaeCurl->get_header());
        $this->assertContains('cool', $this->phpGaeCurl->get_data());
        $this->assertArrayHasKey('apple', $this->phpGaeCurl->get_data());
        $this->assertContains('better', $this->phpGaeCurl->get_data());
        $this->assertArrayHasKey('orange', $this->phpGaeCurl->get_data());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_POSTFIELDS, array('grape' => 'ya'));
        $this->assertContains('Content-type: multipart/form-data', $this->phpGaeCurl->get_header());
        $this->assertEquals(1, count($this->phpGaeCurl->get_data()));
        $this->assertContains('ya', $this->phpGaeCurl->get_data());
        $this->assertArrayHasKey('grape', $this->phpGaeCurl->get_data());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_POSTFIELDS, 'grape');
        $this->assertContains('Content-type: application/x-www-form-urlencoded', $this->phpGaeCurl->get_header());
        $this->assertEquals(1, count($this->phpGaeCurl->get_data()));
        $this->assertContains('grape', $this->phpGaeCurl->get_data());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_URL, 'f');
        $this->assertEquals('f', $this->phpGaeCurl->get_url());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_POST, TRUE);
        $this->assertEquals('POST', $this->phpGaeCurl->get_method());
        $this->assertContains('Content-type: application/x-www-form-urlencoded', $this->phpGaeCurl->get_header());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_PUT, TRUE);
        $this->assertEquals('PUT', $this->phpGaeCurl->get_method());
        
        curl_setopt($this->phpGaeCurl, CURLOPT_CUSTOMREQUEST, 'PUSSY');
        $this->assertEquals('PUSSY', $this->phpGaeCurl->get_method());
    }
    
    public function testCurl_close()
    {
        $this->assertEmpty($this->phpGaeCurl->get_header());
    }
}