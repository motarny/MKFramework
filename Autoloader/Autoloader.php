<?php
namespace MKFramework\Autoloader;

/**
 * Klasa obsługująca automatyczne ładowanie klas.
 * Obsługa obejmuje zarówno komponenty frameworka jak i kontrolery
 * oraz modele w aplikacji.
 * 
 * @author Marcin
 *
 */
class Autoloader
{

    private static $instance;

    function __construct()
    {}

    /**
     * Metoda statyczna zwracająca instancję autoloadera.
     * 
     * @return \MKFramework\Autoloader\Autoloader
     */
    public static function init()
    {
        if (empty(self::$instance)) {
            self::$instance = new Autoloader();
            self::$instance->clientPaths = array();
            self::$instance->addLoaderPath(explode(PATH_SEPARATOR, get_include_path()));
            
            // self::$instance->addLoaderPath('/var/www/html/mktest.pl/projects/MKFramework');
        }
        self::initAutoloader();
        return self::$instance;
    }

    /**
     * Dodaje nową ścieżkę do kolekcji.
     * 
     * @param string|array $newPath pojedyncza ścieżka lub tablica ścieżek
     */
    public static function addLoaderPath($newPath)
    {
        if (is_array($newPath)) {
            foreach ($newPath as $path) {
                self::$instance->clientPaths[] = $path;
            }
        } else {
            self::$instance->clientPaths[] = $newPath;
        }
        self::initAutoloader();
    }

    /**
     * Zwraca listę ścieżek w kolekcji autoloadera.
     * 
     * @return array
     */
    public static function getAutoloaderPaths()
    {
        return self::$instance->clientPaths;
    }

    
    /**
     * Metoda statyczna inicjująca obsługę autoloadera klas.
     */
    private static function initAutoloader()
    {
        spl_autoload_register(function ($className)
        {
            $paths = Autoloader::getAutoloaderPaths();
            
            $className = str_replace('MKFramework\\', '', $className);
            $fileLocation = str_replace('\\', DIRECTORY_SEPARATOR, trim($className, '\\')) . '.php';
            
            foreach ($paths as $path) {
                $file2load = $path . DIRECTORY_SEPARATOR . $fileLocation;
                
                if (file_exists($file2load)) {
                    require_once ($file2load);
                    return;
                }
            }
            
            // TODO throw Exception
        });
    }
}