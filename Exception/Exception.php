<?php
namespace MKFramework\Exception;

class Exception extends \Exception
{

    public function showMessage()
    {
        return '<b>' . $this->getMessage() . '</b>';
    }
    
    
    public function invalidModule($moduleName)
    {
        echo 'BRAK MODUŁU <b>' . $moduleName . '</b>';
        die();
    }
    
    public function invalidController($controllerName)
    {
        echo 'BRAK KONTROLERA <b>' . $controllerName . '</b>';
        die();
    }
}

?>