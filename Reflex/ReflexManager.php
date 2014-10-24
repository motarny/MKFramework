<?php
namespace MKFramework\Reflex;

// TODO Dokumentacja

use MKFramework;
use MKFramework\Exception\Exception;

class ReflexManager
{

    protected static $_enabled = false;
    
    protected static $_outputArray = array();

    
    function __construct()
    {
        
    }
    
    
    static function enable()
    {
        self::$_enabled = true;
    }

    static function disable()
    {
        self::$_enabled = false;
    }
    
    static function setStatus($status)
    {
        self::$_enabled = (bool) $status;
    }

    static function isEnabled()
    {
        return self::$_enabled;
    }
    
    
    static function addReflex(Reflex $reflexObject)
    {
        self::$_outputArray[] = $reflexObject;
    }
    
    
    static function publishReflex()
    {
        $reflexArray = self::$_outputArray;
        ob_start();
        include APPLICATION_PATH . DIRECTORY_SEPARATOR . 'tools' . DIRECTORY_SEPARATOR . 'reflex.phtml';
        $content = ob_get_clean();
        return $content;
    }
    
    
    
    static function addDefaultContent($controllerClassName, $launchJob)
    {
        $functionContent = ReflexManager::getFunctionPhpSource($controllerClassName, $launchJob);
        
        $reflex = new Reflex(array(
            'type'          => 'phpsource',
            'title'         => 'Controller source',
            'description'   => 'This is a controller for current action (job) php source',
            'content'       => $functionContent,
        ));
        
        ReflexManager::addReflex($reflex);

    }
    
    
    
    static function getFunctionPhpSource($className, $functionName)
    {
        $classInfo = new \ReflectionClass($className);
        $reflectionMethod = $classInfo->getMethod($functionName);
        $funcInfo['startLine']  = $reflectionMethod->getStartLine();
        $funcInfo['endLine']    = $reflectionMethod->getEndLine();
        $funcInfo['sourceFile'] = $reflectionMethod->getFileName();
        
        $funcInfo['docComment'] = $reflectionMethod->getDocComment();

        $fileContents = file_get_contents($funcInfo['sourceFile']);
        
        $sourceArray = explode(PHP_EOL, $fileContents);
        
        $sourceFunctionArray = array_slice($sourceArray, $funcInfo['startLine']-1, $funcInfo['endLine'] - $funcInfo['startLine'] + 1);
        
        $source = implode($sourceFunctionArray);
        
        return $source;

    }
    
    
}
