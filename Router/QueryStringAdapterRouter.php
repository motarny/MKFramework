<?php
namespace MKFramework\Router;

class QueryStringAdapterRouter extends RouterAbstract
{

    protected $_adapterName = 'queryString';

    protected $_defaultQueryElements = array(
        'method' => 'get',
        'module' => '__mod',
        'controller' => '__contr',
        'job' => '__job'
    );

    function __construct()
    {
        $this->setRoutingOption('urlQueryElements', $this->_defaultQueryElements);
        $this->prepareRoutingVariables();
    }

    static function getInstance()
    {
        return new self();
    }

    public function prepareRoutingVariables()
    {
        $urlQueryElements = $this->getRoutingOption('urlQueryElements');
        
        // get module
        $moduleUrlVariable = $urlQueryElements['module'];
        $moduleName = $this->getElementValue($moduleUrlVariable);
        $this->setModuleName($moduleName);
        
        // get module
        $controllerUrlVariable = $urlQueryElements['controller'];
        $controllerName = $this->getElementValue($controllerUrlVariable);
        $this->setControllerName($controllerName);
        
        $jobUrlVariable = $urlQueryElements['job'];
        $jobName = $this->getElementValue($jobUrlVariable);
        $this->setJobName($jobName);
    }

    private function getElementValue($elementName)
    {
        $urlQueryElements = $this->getRoutingOption('urlQueryElements');
        $method = $urlQueryElements['method'];
        
        if ($method == 'get') {
            // echo $elementName;
            return ($_GET[(string) $elementName]);
        }
    }
}

?>