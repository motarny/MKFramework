<?php
namespace MKFramework\Multilang;

class ArrayMultilang extends MultilangAbstract
{

    protected $_currentLanguageArrayKey;
    
    function __construct()
    {}
    
    

    public function setLanguage($lang)
    {
        $this->_currentLanguage = $lang;
    
        $this->_currentLanguageArrayKey = array_search($lang, $this->_translation[0]);
    
        return $this;
    }
    
    
    public function addResources($fileName)
    {
        include_once $this->getFullFilePath($fileName);
        
        $this->_translation = array_merge($this->_translation, $translation);
        
        
        // rebuild index
        $this->_translationIndex = array();
        $index = 0;
        foreach ($this->_translation as $message)
        {
            $this->_translationIndex[] = $message[0];
        }
        
        return $this;
    }
    
    
    
    
}

?>