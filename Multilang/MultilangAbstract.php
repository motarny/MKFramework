<?php
namespace MKFramework\Multilang;

// TODO Dokumentacja 

abstract class MultilangAbstract
{
    
    protected $_translation = array();
    protected $_currentLanguage;
    protected $_translationIndex;
    protected $_missedTranslations;
    
    abstract public function addResources($fileName);
    
    
    public function setLanguage($lang)
    {
        $this->_currentLanguage = $lang;
        
        return $this;
    }
    
    
    public function getCurrentLanguage()
    {
        return $this->_currentLanguage;
    }
    
    
    protected function getFullFilePath($file)
    {
        return APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $file; 
    }
    

    public function translate($message)
    {
        $getIndex = array_search($message, $this->_translationIndex);
    
        if (empty($getIndex)) return $this->addMissedTranslation($message) ;
    
        return $this->_translation[$getIndex][$this->_currentLanguageArrayKey];
    }
    
    
    protected function addMissedTranslation($message)
    {
        $this->_missedTranslations[] = $message;
        return $message;
    }
    
    
    public function getMissedTranslations()
    {
        return $this->_missedTranslations;
    }
    
    
}

?>