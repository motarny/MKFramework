<?php
namespace MKFramework\Router;

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

    protected $_routingOptions;

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
        return $this->_moduleName != '' ? $this->_moduleName : self::defaultModuleName;
    }

    public function getControllerName()
    {
        // TODO przebudowa� do obs�ugi globalnego Config
        return $this->_controllerName != '' ? $this->_controllerName : self::defaultControllerName;
    }

    public function getJobName()
    {
        // TODO przebudowa� do obs�ugi globalnego Config
        return $this->_jobName != '' ? $this->_jobName : self::defaultJobName;
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

    abstract protected function prepareRoutingVariables();

    protected function setModuleName($value)
    {
        $this->_moduleName = strtolower($value);
    }

    protected function setControllerName($value)
    {
        $this->_controllerName = strtolower($value);
    }

    protected function setJobName($value)
    {
        $this->_jobName = strtolower($value);
    }
}

?>