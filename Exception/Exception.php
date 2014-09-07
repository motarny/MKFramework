<?php
namespace MKFramework\Exception;

/**
 * Klasa bazowa obsługi wyjątków w MK Framework.
 * !! DO IMPLEMENTACJI !!
 * 
 * @author Marcin
 *
 */
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
