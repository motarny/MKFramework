<?php
namespace MKFramework\Config;

class Config
{

    protected $_config;

    function __construct($config)
    {
        $formatType = $this->getFormatType($config);
        
        switch ($formatType) {
            case 'array':
                $loader = new LoaderArray($config);
                break;
            case 'ini':
                $loader = new LoaderIni($config);
                break;
            case 'xml':
                $loader = new LoaderXml($config);
                break;
            default:
                throw new \MKFramework\Exception\Exception('Nieobslugiwany typ pliku konfiguracyjnego!');
                break;
        }
        
        $this->_config = $loader->getConfigArray();
    }

    private function getFormatType($config)
    {
        if (is_array($config))
            return "array";
        
        $pathParts = pathinfo($config);
        
        if (isset($pathParts['extension']))
            return $pathParts['extension'];
        
        return 'unknow';
    }

    public function get($arraypath)
    {
        return $this->_config[$arraypath];
    }

    public function getAll()
    {
        return $this->_config;
    }
}
