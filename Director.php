<?php
namespace MKFramework;

use MKFramework\Registry\Registry;
use MKFramework\Router\RouterAbstract;
use MKFramework\View;

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

    static public function setView(View\View $view)
    {
        self::$directorInstance->_view = $view;
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
    
    static public function getDbSupport()
    {
        return self::$directorInstance->_dbSupport;
    }
    
    static public function setDbSupport($db)
    {
        self::$directorInstance->_dbSupport = $db;
    }
}

?>