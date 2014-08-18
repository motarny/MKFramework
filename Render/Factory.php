<?php
namespace MKFramework\Render;

class Factory
{

    const DEFAULT_RENDER_ADAPTER = 'screen';    
    
   function __construct() { }

    static public function getRenderer($adapterName)
    {
        $adapter = !empty($adapterName) ? $adapterName : self::DEFAULT_RENDER_ADAPTER; 
        $namespacePrefix = 'MKFramework\Render';
        $className = $namespacePrefix . '\\' . ucfirst($adapter) . 'AdapterRender';
        
        return $className::getRenderer();

    }
}

?>