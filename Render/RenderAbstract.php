<?php
namespace MKFramework\Render;

use MKFramework\Director;

abstract class RenderAbstract
{

    protected $renderer;

    abstract static public function getRenderer();

    abstract public function render();

    protected function combineLayoutAndView()
    {
        $layout = Director::getLayout();
        $view = Director::getView();
        
        $layout->setViewContent($view->getJobContent());
        
        return $layout->render();
    }
}

?>