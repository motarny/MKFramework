<?php
namespace MKFramework\Router;

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
        
        // if found, sets module,controller and job in this method
        if ($this->checkForShortcuts($url))
        {
            return ;
        }
        
        list($module, $controller, $job) = explode(DIRECTORY_SEPARATOR, $url);
        
        $this->setModuleName($module);
        $this->setControllerName($controller);
        $this->setJobName($job);

        
    }
    
    
    

    
    
}

?>