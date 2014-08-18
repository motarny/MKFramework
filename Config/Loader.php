<?php
namespace MKFramework\Config;

abstract class Loader
{

    protected $_configLoad;

    function __construct($config)
    {
        $this->_configLoad = $config;
    }

    public function getConfigArray()
    {
        return $this->parseConfig();
    }

    /**
     * Zwraca tablic¹½ z konfiguracj¹½ - format domyœlny, do rejestru
     */
    abstract protected function parseConfig();
}

?>