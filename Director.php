<?php
namespace MKFramework;

use MKFramework\Autoloader\Autoloader;
use MKFramework\Registry\Registry;
use MKFramework\Router\RouterAbstract;
use MKFramework\View;
use MKFramework\Session\Session;
use MKFramework\Multilang\MultilangAbstract;

/**
 * Klasa Director służy do wygenerowania i obsługi singletona Director.
 * Director przechowuje instancje najważniejszych komponentów oraz uruchamia konkretne akcje/Joby
 *
 * @author Marcin
 *
 */
class Director
{

    static $directorInstance;

    function __construct()
    {}

    /**
     * Inicjuje Directora (Singleton).
     */
    public static function init()
    {
        if (empty(self::$directorInstance)) {
            self::$directorInstance = new self();
            self::$directorInstance->_appConfigurationObj = Registry::get(REGISTRY_APP_CONFIGURATION, REGISTRY_CORE_NAMESPACE);
        }
    }

    
    public static function getInstance()
    {
        if (empty(self::$directorInstance)) {
            self::init();
        }
        return self::$directorInstance;
    }
    

    /**
     * Metoda statyczna odpowiedzialna za uruchomienie Joba kontrolera i zwrócenie wygenerowanego widoku,
     * oraz wrzucenie go do Layoutu i ostatecznie wyrenderowanie wybranym adapterem Render.
     * 
     * @param string $module
     * @param string $controller
     * @param string $job
     */
    public static function runJob($module, $controller, $job)
    {
        // Startowo zawsze włącz widok i layout. Joby kontrolera mogą go wyłączyć.
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
        
        // Zdefiniowanie nazwy klasy kontrolera wymaganego przez request.
        $controllerClassName = ucfirst($controller) . 'Controller';
        
        Autoloader::addLoaderPath(MODULE_PATH . DIRECTORY_SEPARATOR . 'controller');
   
        // Obsługa memcache ja poziomie Job - TYMCZASOWO 
        // TODO czas z konfiga
        $memcache = Director::getMemcache();
        if ($memcache)
        {
            $memcacheVar = $module . '_' . $controller . '_' . $job . '_' . serialize($router->getParams());
            if ($memcache->get($memcacheVar))
            {
                $jobContent = $memcache->get($memcacheVar);
            }
            else
            {
                // uruchom odpowiedni Job kontrolera
                $controller = new $controllerClassName();
                $jobContent = $controller->getJobContent($launchJob);
                $memcache->set($memcacheVar, $jobContent, MEMCACHE_COMPRESSED, 120);
            }
        } else 
        {
            // uruchom odpowiedni Job kontrolera
            $controller = new $controllerClassName();
            $jobContent = $controller->getJobContent($launchJob);            
        }
        
        $render = Render\Factory::getRenderer('screen'); // empty value = screen, try 'file' adapter
        
        Director::getLayout()->setLayoutFile('default');
        Director::getView()->setJobContent($jobContent);
        
        
        // Zwróć wynik.
        $render->render();
        
    }
    
    
    /**
     * Inicjalizacja memcache.
     */
    public static function initMemcache()
    {
        // TODO dodać obsługę sprawdzania, czy jest dostępny!
        
        // check if enabled
        $isMemcachedEnabled = \MKFramework\Director::getSession()->isMemcachedEnabled;
        if ($isMemcachedEnabled)
        {
            $memcache = new \Memcache();
            @$memcache->connect("localhost");
            self::$directorInstance->_memcache = $memcache;
        }
    }
    
    /**
     * Memcache getter.
     */
    public static function getMemcache()
    {
        return self::$directorInstance->_memcache;
    }
    
    
    
    public static function openUrl($url)
    {
        // TODO przerobić na header('...
        echo "<script lang=javascript>document.location.href='". $url . "'; </script>";
    }
    

    public static function finish()
    {
        include_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'Finish.php';
    }

    public static function getAppConfig($var = null)
    {
        if ($var == null)
            return self::$directorInstance->_appConfigurationObj;
        return self::$directorInstance->_appConfigurationObj->get($var);
    }

    
    /*
     * 
     * Gettery i settery głównych komponentów.
     * 
     */
    
    public static function setRouter(RouterAbstract $routerObject)
    {
        self::$directorInstance->_router = $routerObject;
    }

    public static function getRouter()
    {
        return self::$directorInstance->_router;
    }

    public static function setMultilang(MultilangAbstract $multilangObject)
    {
        self::$directorInstance->_multilang = $multilangObject;
    }

    public static function getMultilang()
    {
        return self::$directorInstance->_multilang;
    }

    public static function setView(View\View $view)
    {
        self::$directorInstance->_view = $view;
    }

    public static function getSession()
    {
        return self::$directorInstance->_session;
    }

    public static function setSession(Session $session)
    {
        self::$directorInstance->_session = $session;
    }

    public static function getView()
    {
        return self::$directorInstance->_view;
    }

    public static function setLayout(View\Layout $layout)
    {
        self::$directorInstance->_layout = $layout;
    }

    public static function getLayout()
    {
        return self::$directorInstance->_layout;
    }

    public static function getModuleName()
    {
        return self::$directorInstance->_router->getModuleName();
    }

    public static function getControllerName()
    {
        return self::$directorInstance->_router->getControllerName();
    }

    public static function getJobName()
    {
        return self::$directorInstance->_router->getJobName();
    }

    public static function getDbalSupport()
    {
        return self::$directorInstance->_dbSupport;
    }

    public static function setDbalSupport($db)
    {
        self::$directorInstance->_dbSupport = $db;
    }

    public static function getOrmSupport()
    {
        return self::$directorInstance->_ormSupport;
    }
    
    public static function setOrmSupport($entityManager)
    {
        self::$directorInstance->_ormSupport = $entityManager;
    }
}
