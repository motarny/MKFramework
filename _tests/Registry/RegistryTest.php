<?php

use \MKFramework\Registry\Registry;

class RegistryTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        Registry::init();
    }
    
    
     
     public function testRegistryAdd()
     {
        Registry::set('zmiena', 'wartosc');
        
     }

}

  