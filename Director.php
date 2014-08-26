<?php
namespace MKFramework;

use MKFramework\Autoloader\Autoloader;
use MKFramework\Registry\Registry;
use MKFramework\Router\RouterAbstract;
use MKFramework\View;
use MKFramework\Session\Session;
use MKFramework\Multilang\MultilangAbstract;

class Director
{

    static $directorInstance;

    function __construct()
    {}

    static public function init()
    {
        if (empty(self::$directorInstance)) {
            self::$directorInstance = new self();
            self::$directorInstance->_appConfigurationObj = Registry::get(REGISTRY_APP_CONFIGURATION, REGISTRY_CORE_NAMESPACE);
        }
    }

    static public function runJob($module, $controller, $job)
    {
        // always enable on start in case of controllerJob reRun this and there was view/layout disabled
        self::getView()->enable();
        self::getLayout()->enable();
        
        $router = self::getRouter();
        
        $router->setModuleName($module);
        $router->setControllerName($controller);
        $router->setJobName($job);
        
        self::setRouter($router);
        
        $openModule = Director::getModuleName();
        $openController = Director::getControllerName();
        $launchJob = Director::getJobName() . 'Job';
        
        $controllerClassName = ucfirst($controller) . 'Controller';
        
        Autoloader::addLoaderPath(MODULE_PATH . DIRECTORY_SEPARATOR . 'controller');
        
        // uruchom odpowiedni Job kontrolera
        $controller = new $controllerClassName();
        
        $jobContent = $controller->getJobContent($launchJob);
        $render = Render\Factory::getRenderer('screen'); // empty value = screen, try 'file' adapter
        
        Director::getLayout()->setLayoutFile('default');
        Director::getView()->setJobContent($jobContent);
        
        $render->render();
        
    }
    
    
    static public function openUrl($url)
    {
        echo "<script lang=javascript>document.location.href='". $url . "'; </script>";
    }
    

    static public function finish()
    {
        include_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'Finish.php';
    }

    static public function getInstance()
    {
        if (empty(self::$directorInstance)) {
            self::init();
        }
        return self::$directorInstance;
    }

    static public function getAppConfig($var = null)
    {
        if ($var == null)
            return self::$directorInstance->_appConfigurationObj;
        return self::$directorInstance->_appConfigurationObj->get($var);
    }

    static public function setRouter(RouterAbstract $routerObject)
    {
        self::$directorInstance->_router = $routerObject;
    }

    static public function getRouter()
    {
        return self::$directorInstance->_router;
    }

    static public function setMultilang(MultilangAbstract $multilangObject)
    {
        self::$directorInstance->_multilang = $multilangObject;
    }

    static public function getMultilang()
    {
        return self::$directorInstance->_multilang;
    }

    static public function setView(View\View $view)
    {
        self::$directorInstance->_view = $view;
    }

    static public function getSession()
    {
        return self::$directorInstance->_session;
    }

    static public function setSession(Session $session)
    {
        self::$directorInstance->_session = $session;
    }

    static public function getView()
    {
        return self::$directorInstance->_view;
    }

    static public function setLayout(View\Layout $layout)
    {
        self::$directorInstance->_layout = $layout;
    }

    static public function getLayout()
    {
        return self::$directorInstance->_layout;
    }

    static public function getModuleName()
    {
        return self::$directorInstance->_router->getModuleName();
    }

    static public function getControllerName()
    {
        return self::$directorInstance->_router->getControllerName();
    }

    static public function getJobName()
    {
        return self::$directorInstance->_router->getJobName();
    }

    static public function getDbalSupport()
    {
        return self::$directorInstance->_dbSupport;
    }

    static public function setDbalSupport($db)
    {
        self::$directorInstance->_dbSupport = $db;
    }

    static public function getOrmSupport()
    {
        return self::$directorInstance->_ormSupport;
    }
    
    static public function setOrmSupport($entityManager)
    {
        self::$directorInstance->_ormSupport = $entityManager;
    }
}
