<?php
namespace MKFramework\Multilang;

/**
 * Klasa fabryka dla obsługi wielojęzyczności.
 * 
 * @author Marcin
 *
 */
class Factory
{

    function __construct()
    {}
    
    
    /**
     * Metoda statyczna generująca instancję klasy obsługi wielojęzyczności zgodnie z podanym adapterem.
     *  
     * @param string $multilangAdapter adapter wykorzystywany do obsługi wielojęzyczności
     * @throws \MKFramework\Exception\Exception
     * @return MultilangAbstract
     */
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