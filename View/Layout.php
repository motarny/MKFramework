<?php
namespace MKFramework\View;

use MKFramework\Director;

class Layout extends TemplateServiceAbstract
{

    protected $_variables;

    protected $_layoutFile = 'default';

    protected $_layoutFileFullPath;

    protected $_tplExtension = 'phtml';

    protected $_viewContent;

    public function render()
    {
        if (empty($this->_layoutFileFullPath)) {
            $this->setLayout($this->_layoutFile);
        }
        
        if (! $this->isDisabled()) {
            $layout = $this;
            ob_start();
            include $this->_layoutFileFullPath;
            $cont = ob_get_clean();
            
            return $cont;
        }
    }

    public function setLayoutFile($layoutFile)
    {
        $this->_layoutFile = $layoutFile . '.' . $this->_tplExtension;
        $this->_layoutFileFullPath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . Director::getModuleName() . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . $this->_layoutFile;
    }

    public function setViewContent($content)
    {
        $this->_viewContent = $content;
    }

    public function getViewContent()
    {
        return $this->_viewContent;
    }
}

?>