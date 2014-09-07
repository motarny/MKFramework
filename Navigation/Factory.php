<?php
namespace MKFramework\Navigation;

// TODO Dokumentacja

/** 
  * @author Marcin
 * 
 */

class Factory
{
    // TODO - Insert your code here
    
    /**
     */
    function __construct() {}
    
    
    static function getInstance($navigationStyle)
    {
        $namespacePrefix = 'MKFramework\Navigation';
        $className = $namespacePrefix . '\\' . ucfirst($navigationStyle) . 'Navigation';
        
        if (! class_exists($className)) {
            throw new \MKFramework\Exception\Exception('Nieprawidłowa klasa generatora nawigacji');
        }
        
        return new $className();
 
    }
}
