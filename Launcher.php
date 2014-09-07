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

    
    /**
     * Metoda statyczna uruchamiana z pliku startowego aplikacji.
     *
     * @param string $configFile
     */
    public static function launchFrameworkApplication($configFile)
    {
        
        // Inicjalizacja autoloadera
        require_once 'Autoloader/Autoloader.php';
        Autoloader::init();
        Autoloader::addLoaderPath(APPLICATION_PATH);
        Autoloader::addLoaderPath(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public');
        
        // Wczytanie konfiguracji do rejestru
        Registry::set(null, new Config($configFile), REGISTRY_CORE_NAMESPACE);
        
        // Inicjalizacja komponentu Director, który zarządza wykonywaniem całego requesta.
        // Director przechowuje instancje do głównych komponentów.
        Director::init();
        
        // Uruchamiamy sesję.
        Director::setSession(Session::getInstance(Director::getAppConfig('sessionAdapter')));
        
        
        // Uruchamiamy memcache.
        Director::initMemcache();
        
        // Inicjalizacja komponentu Router, który odczytuje parametry requesta.
        // Router dodawany jest do Directora.        
        $router = new Router\Factory(Director::getAppConfig('routerAdapter'));
        Director::setRouter($router->getRouter());
        
        // Inicjalizacja Layoutu i przypisanie go do Directora.
        Director::setLayout(new Layout());
        
        // Inicjalizacja Widoku i przypisanie go do Directora.
        Director::setView(new View());
        
        // W tym momencie możemy odpalić jakieś zdefiniowane przez klienta automatyczne działania.
        // Działania określone są w pliku Bootstrap.php w aplikacji
        $bootstrap = new \Bootstrap();
        $bootstrap->init();
        
        // Oprócz głównego bootstrapa dla aplikacji, możemy także uruchomić bootstrapa dla modułu,
        // o ile taki bootstrap istnieje.
        if (file_exists(MODULE_PATH . DIRECTORY_SEPARATOR . 'ModuleBootstrap.php')) {
            Autoloader::addLoaderPath(MODULE_PATH);
            $bootstrapModule = new \ModuleBootstrap();
            $bootstrapModule->init();
        }
        
        // Odczytajmy parametry routingu i wykonajmy odpowiedni Job w kontrolerze.
        $openModule = Director::getModuleName();
        $openController = Director::getControllerName();
        $launchJob = Director::getJobName();
        Director::runJob($openModule, $openController, $launchJob);
        
        
        // Director spróbuje także odpalić plik Finish.php w aplikacji, jeśli taki istnieje.
        // W pliku tym możemy wstawić dowolny kod, który ma coś wykonać na sam koniec.
        Director::finish(); 
    }

    
    public function forTest()
    {
        return "ok";
    }
   
    
}


