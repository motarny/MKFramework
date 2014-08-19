<?php
namespace MKFramework;

use MKFramework\Director as Director;
use MKFramework\Config\Config as Config;
use MKFramework\View\View as View;
use MKFramework\Autoloader\Autoloader;

abstract class BootstrapAbstract
{

    function __construct()
    {}

    public function launchAutoloaderPaths()
    {
        // default models path
        Autoloader::addLoaderPath(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'model');
    }

    /**
     * Uruchamia metody bootstrapa
     */
    public function init()
    {
        $initActions = $this->getLaunchActions();
        foreach ($initActions as $methodName) {
            $this->$methodName();
        }
    }
    
    // Funkcje standardowe, kt�re si� musz� zawsze odpali�
    //
    //
    
    /**
     * Zwraca list� metod w klasie Bootstrapper w formacie launch***** do uruchomienia
     *
     * @return array
     */
    protected function getLaunchActions()
    {
        $classMethods = get_class_methods($this);
        return array_filter($classMethods, function ($methodName)
        {
            $pattern = '/^launch[A-Z]{1,}[a-zA-Z0-9]{0,}$/';
            return preg_match($pattern, $methodName);
        });
    }
}