<?php
namespace MKFramework\Render;

// TODO Dokumentacja

class FileAdapterRender extends RenderAbstract
{

    protected $_fileName;

    protected $_contentType;

    static function getRenderer()
    {
        return new self();
    }

    public function render()
    {
        header("Content-type: " . $this->_contentType);
        header("Content-Disposition: attachment; filename=\"" . basename($this->_fileName) . "\"");

        $content = $this->combineLayoutAndView();
        
        echo $content;
    }

    public function setFileName($fileName)
    {
        $this->_fileName = $fileName;
    }

    public function setHeaderContentType($contentType)
    {
        $this->_contentType = $contentType;
    }


}
