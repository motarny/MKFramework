<?php
namespace MKFramework\View;

use MKFramework\Front;
use MKFramework\Director;

class View extends TemplateServiceAbstract
{

    protected $_variables;

    protected $_viewFile;

    protected $_tplExtension = 'phtml';

    protected $_renderer = 'screen';
    
    protected $_isDisabled = false;
    
    protected $_jobContent;



    public function render()
    {
        if (!$this->isDisabled())
        {
            // TODO przerobi� na co� bardziej uniwersalnego (np. do pliku czy innego strumienia)
            // TODO obsluga layoutow do zrobienia
            $v = $this;
            ob_start();
            include $this->_viewFile;
            $cont = ob_get_clean();
            
            return $cont;
        }
    }
    

    public function setJobContent($content)
    {
        $this->_jobContent = $content;
    }
    
    public function getJobContent()
    {
        return $this->_jobContent;
    }
    
    
    public function setView($controller, $job)
    {
        $this->_viewFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . Director::getModuleName() . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . ucfirst($controller) . DIRECTORY_SEPARATOR . $job . '.' . $this->_tplExtension;
    }

    
}


