<?php
namespace MKFramework\View;

use MKFramework\Director;

class TemplateServiceAbstract
{

    protected $_variables;

    protected $_tplExtension = 'phtml';

    protected $_isDisabled = false;
    
    protected $_helper;

    function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * Daje mo�liwo�� ustawiania zmiennej do widoku
     * w formie $view->VARIABLE = $value
     *
     * @param unknown $variable            
     * @param unknown $value            
     */
    public function __set($variable, $value)
    {
        $this->_variables[$variable] = $value;
        return $this->_variables;
    }

    /**
     * Daje dost�p do zmiennych zadeklarowanych do widoku
     * w formie $this->VARIABLE
     *
     * @param unknown $variable            
     */
    public function __get($variable)
    {
        if ($variable == 'helper')
        {
            return $this->_helper;
        }
        return $this->_variables[$variable];
    }

    public function isDisabled()
    {
        return $this->_isDisabled;
    }

    public function disable()
    {
        $this->_isDisabled = true;
    }

    public function enable()
    {
        $this->_isDisabled = false;
    }

    public function getAllVariables()
    {
        return $this->_variables;
    }
    
   
    
    
}


