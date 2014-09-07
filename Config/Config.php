<?php
namespace MKFramework\Config;

/**
 * Klasa obsługująca konfigurację aplikacji.
 * 
 * @author Marcin
 *
 */
class Config
{

    /**
     * @var array
     */
    protected $_config;

    
    /**
     * Konstruktor klasy Config.
     * 
     * @param string $config ścieżka i nazwa pliku z konfiguracją 
     * @throws \MKFramework\Exception\Exception
     */
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

    
    /**
     * Metoda wykrywająca jaki typ pliku z konfiguracją został dostarczony.
     * 
     * @param string $config ścieżka i nazwa pliku z konfiguracją 
     * @return string
     */
    private function getFormatType($config)
    {
        if (is_array($config))
            return "array";
        
        $pathParts = pathinfo($config);
        
        if (isset($pathParts['extension']))
            return $pathParts['extension'];
        
        return 'unknow';
    }

    /**
     * Metoda zwracająca wartość z załadowanej konfiguracji.
     * 
     * @param string zmienna
     * @return mixed
     */
    public function get($arraypath)
    {
        return $this->_config[$arraypath];
    }

    /**
     * Metoda zwracająca całą konfigurację w formie tablicy.
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->_config;
    }
}
