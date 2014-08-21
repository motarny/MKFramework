<?php
namespace MKFramework\Router;

use MKFramework\Exception\Exception;
use MKFramework\Autoloader\Autoloader;

/**
 *
 * @author Marcin
 *        
 */
abstract class RouterAbstract
{

    const defaultModuleName = 'default';

    const defaultControllerName = 'index';

    const defaultJobName = 'index';

    /**
     *
     * @var string
     * @access protected
     */
    protected $_moduleName;

    /**
     *
     * @var string
     * @access protected
     */
    protected $_controllerName;

    /**
     *
     * @var string
     * @access protected
     */
    protected $_jobName;

    protected $_shortcuts = array();

    protected $_routingOptions;

    protected $_urlParams;

    /**
     * Returns RouterAbstract Singleton object
     *
     * @access public
     * @return RouterAdapterObject
     */
    abstract static function getInstance();

    /**
     * Return array with routing variables
     *
     * @access public
     * @return array (moduleName, controllerName, actionName)
     */
    public function getRouting()
    {
        return array(
            'moduleName' => $this->getModuleName(),
            'controllerName' => $this->getControllerName(),
            'jobName' => $this->getJobName()
        );
    }

    public function getModuleName()
    {
        // TODO przebudowa� do obs�ugi globalnego Config
        return $this->_moduleName;
    }

    public function getControllerName()
    {
        // TODO przebudowa� do obs�ugi globalnego Config
        return $this->_controllerName;
    }

    public function getJobName()
    {
        // TODO przebudowa� do obs�ugi globalnego Config
        return $this->_jobName;
    }

    public function getAdapterName()
    {
        return $this->_adapterName;
    }

    public function setRoutingOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->_routingOptions[$option] = $value;
        }
    }

    public function setRoutingOption($option, $value)
    {
        $this->_routingOptions[$option] = $value;
    }

    public function getRoutingOptions()
    {
        return $this->_routingOptions;
    }

    public function getRoutingOption($option)
    {
        return $this->_routingOptions[$option];
    }

    public function getDefaultElementName($elementName)
    {
        switch ($elementName) {
            case 'moduleName':
                return self::defaultModuleName;
            case 'controllerName':
                return self::defaultModuleName;
            case 'jobName':
                return self::defaultJobName;
        }
    }

    public function getParams($paramName = null)
    {
        if (empty($paramName)) {
            return $this->_urlParams;
        } else {
            return $this->_urlParams[strtolower($paramName)];
        }
    }

    abstract public function prepareRoutingVariables();

    public function setModuleName($value)
    {
        $value = empty($value) ? self::defaultModuleName : $value;
        
        try {
            $this->checkModuleExists($value);
        } catch (Exception $e) {
            $e->invalidModule($value);
        }
        $this->_moduleName = strtolower($value);
        define('MODULE_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $value);
    }

    public function setControllerName($value)
    {
        $value = empty($value) ? self::defaultControllerName : $value;
        
        try {
            $this->checkControllerExists($value);
        } catch (Exception $e) {
            $e->invalidController($value);
        }
        $this->_controllerName = strtolower($value);
    }

    public function setJobName($value)
    {
        // Checking if Job exists will be done in Controller
        $value = empty($value) ? self::defaultJobName : $value;
        $this->_jobName = strtolower($value);
    }

    protected function setUrlParams($paramsArray)
    {
        $this->_urlParams = $paramsArray;
    }

    public function addShortcut($url, $redirectTo)
    {
        $url = trim($url, ' ' . DIRECTORY_SEPARATOR);
        $this->_shortcuts[$url] = $redirectTo;
    }

    protected function checkForShortcuts($url)
    {
        if (array_key_exists($url, $this->_shortcuts)) {
            list ($module, $controller, $job) = explode(DIRECTORY_SEPARATOR, $this->_shortcuts[$url]);
            $this->setModuleName($module);
            $this->setControllerName($controller);
            $this->setJobName($job);
            
            return true;
        }
        
        return false;
    }

    abstract public function prepareUrl($routingParams);

    private function checkModuleExists($checkModule)
    {
        if ($checkModule == 'default')
            return true;
        $dirCheck = 'modules' . DIRECTORY_SEPARATOR . $checkModule;
        if (! file_exists($dirCheck)) {
            // TODO do dopracowania
            throw new Exception();
        }
    }
    
    private function checkControllerExists($checkController)
    {
        $controllerClassName = ucfirst($checkController) . 'Controller';
        
        Autoloader::addLoaderPath(MODULE_PATH . DIRECTORY_SEPARATOR . 'controller');
        
        if (! class_exists($controllerClassName)) {
            // TODO do dopracowania
            throw new Exception();
        }
        
    }
    
    
}
