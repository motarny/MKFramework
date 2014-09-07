<?php
namespace MKFramework;

use MKFramework\Director as Director;
use MKFramework\Config\Config as Config;
use MKFramework\View\View as View;
use MKFramework\Autoloader\Autoloader;

/**
 * Klasa abstrakcyjna dla bootstrapa.
 * Zawiera podstawowe narzędzia do uruchamiania metod 
 * jak i kilka standardowych, zawsze uruchamianych metod. 
 * @author Marcin
 *
 */
abstract class BootstrapAbstract
{

    function __construct()
    {}

    /**
     * Dodaje do ściezki autoloadera folder 'model' z głównego katalogu aplikacji.
     */
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
    
    
    /**
     * Zwraca listę metod w klasie Bootstrapper w formacie launch***** do uruchomienia.
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