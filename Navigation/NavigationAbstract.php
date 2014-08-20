<?php
namespace MKFramework\Navigation;

use MKFramework;

/**
 *
 * @author Marcin
 *        
 */
abstract class NavigationAbstract
{

    protected $_navigationElements;

    protected $_cssClasses;

    protected $_multilang;

    /**
     */
    function __construct()
    {
        $this->setMultilangInstance();
    }


    abstract public function renderNavigation();    
    
    protected function setMultilangInstance()
    {
        $multilang = MKFramework\Director::getMultilang();
        if (! empty($multilang)) {
            $this->_multilang = $multilang;
        }
    }

    protected function translate($message)
    {
        if (empty($this->_multilang)) return $message;
       
        return $this->_multilang->translate($message);
    }
    
    public function setNavigationElements($elements = array())
    {
        $this->_navigationElements = $elements;
    }

    public function setCssClasses($options = array())
    {
        $this->_cssClasses = $options;
    }
}
