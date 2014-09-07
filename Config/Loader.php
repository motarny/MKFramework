<?php
namespace MKFramework\Config;

/**
 * Klasa abstrakcyjna loadera konfiguracji.
 * 
 * @author Marcin
 *
 */
abstract class Loader
{

    /**
     * @var ścieżka i plik z konfiguracją
     */
    protected $_configLoad;

    /**
     * Konstruktor loadera konfiguracji.
     * 
     * @param string $config ścieżja i plik z konfiguracją
     */
    function __construct($config)
    {
        $this->_configLoad = $config;
    }

    /**
     * Metoda zwraca tablicę z konfiguracją.
     * 
     * @return array
     */
    public function getConfigArray()
    {
        return $this->parseConfig();
    }

    /**
     * Zwraca tablicę z konfiguracją - format domyślny, do rejestru
     */
    abstract protected function parseConfig();
}
