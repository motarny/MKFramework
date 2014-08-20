<?php
namespace MKFramework\Render;

class ScreenAdapterRender extends RenderAbstract
{

    static function getRenderer()
    {
        return new self();
    }

    public function render()
    {
        $content = $this->combineLayoutAndView();
        
        echo $content;
    }
}
