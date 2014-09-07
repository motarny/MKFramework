<?php



class LauncherTest extends PHPUnit_Framework_TestCase
{

    protected $launcher;
    
    protected function setUp()
    {
        $this->launcher = new \MKFramework\Launcher();
    }
    
    
     
     public function testLauncherInitTest2()
     {
         $result = $this->launcher->forTest();
         $this->assertEquals("ok", $result);
     }

}

  