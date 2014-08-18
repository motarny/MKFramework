<?php
namespace MKFramework\Autoloader;

class Autoloader
{

    private static $instance;

    function __construct()
    {}

    public static function init()
    {
        if (empty(self::$instance)) {
            self::$instance = new Autoloader();
            self::$instance->clientPaths = array();
            self::$instance->addLoaderPath(explode(PATH_SEPARATOR, get_include_path()));
            self::$instance->addLoaderPath('/var/www/html/mktest.pl/projects/MKFramework');
        }
        self::initAutoloader();
        return self::$instance;
    }

    static public function addLoaderPath($newPath)
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

    static public function getAutoloaderPaths()
    {
        return self::$instance->clientPaths;
    }

    static private function initAutoloader()
    {
        spl_autoload_register(function ($className)
        {
            
            // $paths = explode(PATH_SEPARATOR, get_include_path());
            $paths = Autoloader::getAutoloaderPaths();
            
            $className = str_replace('MKFramework\\', '', $className);
            $fileLocation = str_replace('\\', DIRECTORY_SEPARATOR, trim($className, '\\')) . '.php';
            
            foreach ($paths as $path) {
                $file2load = $path . DIRECTORY_SEPARATOR . $fileLocation;
                
                if (file_exists($file2load)) {
                    require_once ($file2load);
                    // echo 'wczytuje ' . $file2load . '<Br>';
                    return;
                }
            }
            
            // TODO throw Exception
        });
    }
}