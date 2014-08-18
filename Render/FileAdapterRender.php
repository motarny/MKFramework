<?php
namespace MKFramework\Render;

class FileAdapterRender extends RenderAbstract
{
 
    static function getRenderer()
    {
        return new self();
    }

    public function render()
    {
        $content = $this->combineLayoutAndView();
        
        echo "DO PLIKU";
        
        echo $content;
    }
    
    
    
    
    
}

?>