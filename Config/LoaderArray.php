<?php
namespace MKFramework\Config;

class LoaderArray extends Loader
{

    protected function parseConfig()
    {
        return $this->_configLoad;
    }
}

?>