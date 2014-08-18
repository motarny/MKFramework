<?php
namespace MKFramework\Router;

class Factory
{

    private $_adapterName = 'default';

    private $_adapter;

    function __construct($adapterName)
    {
        if ($adapterName != '')
            $this->_adapterName = $adapterName;
    }

    public function getRouter()
    {
        $namespacePrefix = 'MKFramework\Router';
        $className = $namespacePrefix . '\\' . ucfirst($this->_adapterName) . 'AdapterRouter';
        
        if (! class_exists($className)) {
            throw new \MKFramework\Exception\Exception('Nieprawidłowa klasa adaptera routingu');
        }
        
        $this->_adapter = $className::getInstance();
        
        return $this->_adapter;
    }
}

?>