<?php

namespace MKFramework\Reflex;

// TODO Dokumentacja

use MKFramework;
use MKFramework\Exception\Exception;

class Reflex
{

    protected $_reflexFields = array();
    
    function __construct(array $reflexData)
    {
        foreach ($reflexData as $fieldName => $fieldValue)
        {
            $this->_reflexFields[$fieldName] = $fieldValue;
        }
        
        return $this;
    }
    
    
    public function __get($variable)
    {
        return $this->_reflexFields[$variable];
    }
    
    
    
}

?>