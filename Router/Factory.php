<?php
namespace MKFramework\Router;

// TODO Dokumentacja

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
        
        // Add routing tracks if defined
        $router = $this->_adapter;
        include_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'Routetracks.php';
        
        $this->_adapter->prepareRoutingVariables();
        
        return $this->_adapter;
    }
}
