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
use MKFramework\Session\Session;
use MKFramework\Exception\Exception;

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
        
        // Let's start the session
        Director::setSession(Session::getInstance(Director::getAppConfig('sessionAdapter')));
        
        // Of course, we need some routing functions.        
        $router = new Router\Factory(Director::getAppConfig('routerAdapter'));
        Director::setRouter($router->getRouter());
        // define('MODULE_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . Director::getModuleName());
        
        // Let's director holds Layout functionalities...
        Director::setLayout(new Layout());
        
        // ...and View, for specific Controllers Jobs (View holds Controller/Job result).
        Director::setView(new View());
        
        // Good moment for launchinch some required actions from application Bootstrap.php file.
        $bootstrap = new \Bootstrap();
        $bootstrap->init();
        
        // Also launch module bootstrap if exists.
        if (file_exists(MODULE_PATH . DIRECTORY_SEPARATOR . 'ModuleBootstrap.php')) {
            Autoloader::addLoaderPath(MODULE_PATH);
            $bootstrapModule = new \ModuleBootstrap();
            $bootstrapModule->init();
        }
        
        // So, now everything is set up and we can launch Conntroller Job
        $openModule = Director::getModuleName();
        $openController = Director::getControllerName();
        $launchJob = Director::getJobName();
        Director::runJob($openModule, $openController, $launchJob);
        
        
        // Sometimes something must be done after all
        Director::finish(); 
    }


}


