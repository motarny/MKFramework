<?php
namespace MKFramework\Router;

// TODO Dokumentacja

class DefaultAdapterRouter extends RouterAbstract
{

    protected $_adapterName = 'default';

    static $instance;

    static function getInstance()
    {
        self::$instance = new self();
        return self::$instance;
    }

    public function prepareRoutingVariables()
    {
        $url = $_GET['url'];
        $params = strtolower($_GET['params']);
        
        $params = str_replace('$', '', $params);
        $params = str_replace(';', '&', $params);
        
        parse_str($params, $paramsArray);
        
        // if found, sets module,controller and job in this method
        if ($this->checkForShortcuts($url)) {
            return;
        }
        
        list ($module, $controller, $job) = explode(DIRECTORY_SEPARATOR, $url);
        
        $this->setModuleName($module);
        $this->setControllerName($controller);
        $this->setJobName($job);
        
        $this->setUrlParams($paramsArray);
    }
    
    
    public function prepareUrl($routingParams)
    {
        $module         = $routingParams['module']      != '' ? $routingParams['module']      : $this->getModuleName();
        $controller     = $routingParams['controller']  != '' ? $routingParams['controller']  : 'index';
        $job            = $routingParams['job']         != '' ? $routingParams['job']         : 'index';
        
        $params         = $routingParams['params'];
        
        if (!empty($params)) $paramsList = DIRECTORY_SEPARATOR . '$' . str_replace('&', ';', http_build_query($params));
        
        $preparedUrl = DOCUMENT_ROOT . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $controller . DIRECTORY_SEPARATOR . $job . $paramsList;
        
        return $preparedUrl;
        
    }
    
}
