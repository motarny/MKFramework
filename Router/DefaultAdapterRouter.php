<?php
namespace MKFramework\Router;

class DefaultAdapterRouter extends RouterAbstract
{

    protected $_adapterName = 'default';

    static function getInstance()
    {
        return new self();
    }

    protected function prepareRoutingVariables()
    {
        //
    }
}

?>