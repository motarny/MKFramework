<?php

namespace MKFramework;

define('REGISTRY_DEFAULT_NAMESPACE', 'default');
define('REGISTRY_CORE_NAMESPACE', '##core');
define('REGISTRY_APP_CONFIGURATION', 'appConfiguration');

use MKFramework\Registry\Registry;
use MKFramework\Autoloader\Autoloader;
use MKFramework\Config\Config;
use MKFramework\Director;
use MKFramework\Router;
use MKFramework\View\View;
use MKFramework\View\Layout;

final class Launcher
{

    function __construct()
    {}

    public static function launchFrameworkApplication($configFile)
    {
      
        // Initialize Autoloader.
        require_once 'Autoloader/Autoloader.php';
        Autoloader::init();
        Autoloader::addLoaderPath(APPLICATION_PATH);
        Autoloader::addLoaderPath(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public');
        
        // Now, when we have Autoloader initialized, load app configuration to framework Registry...
        Registry::set(null, new Config($configFile), REGISTRY_CORE_NAMESPACE);
        
        // ...and then, initialize Director, which holds everything 
        Director::init();

        // Of course, we need some routing functions.
        
        $router = (new Router\Factory(Director::getAppConfig('routerAdapter')));
        Director::setRouter($router->getRouter());
        
        // Good moment for launchinch some required actions from application Bootstrap.php file.
        $bootstrap = new \Bootstrap();
        $bootstrap->init();
        
        // Let's director holds Layout functionalities...
        Director::setLayout(new Layout());
        
        // ...and View, for specific Controllers Jobs (View holds Controller/Job result).
        Director::setView(new View());
        
        
        // So, now everything is set up and we can launch Conntroller Job
        self::doTheDance();
    }


    /**
     * Uruchamia Controller/Job
     */
    static public function doTheDance()
    {
        
        // pobierz informacje o routingu
        $openModule = Director::getModuleName();
        $openController = Director::getControllerName();
        $launchJob = Director::getJobName() . 'Job';
        
        $controllerClassName = ucfirst($openController) . 'Controller';
        
        Autoloader::addLoaderPath(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $openModule . DIRECTORY_SEPARATOR . 'controller');
        
        // uruchom odpowiedni Job kontrolera
        $controller = new $controllerClassName();
        
        $jobContent = $controller->getJobContent($launchJob);
        Director::getView()->setJobContent($jobContent);
        
        $render = Render\Factory::getRenderer('screen');  // empty value = screen, try 'file' adapter
        
        Director::getLayout()->setLayoutFile('default');
        
        $render->render();
    }
}


