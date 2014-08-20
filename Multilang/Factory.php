<?php
namespace MKFramework\Multilang;

class Factory
{

    function __construct()
    {}
    
    
    static function getInstance($multilangAdapter)
    {
        $namespacePrefix = 'MKFramework\Multilang';
        $className = $namespacePrefix . '\\' . ucfirst($multilangAdapter) . 'Multilang';
        
        if (! class_exists($className)) {
            throw new \MKFramework\Exception\Exception('Nieprawidłowa klasa generatora multilang');
        }
        
        return new $className();
 
    }
    
}

?>