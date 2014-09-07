<?php
namespace MKFramework\Config;

/**
 * Klasa odczytująca konfigurację w formie zwykłej tablicy php.
 * @author Marcin
 *
 */
class LoaderArray extends Loader
{

    protected function parseConfig()
    {
        return $this->_configLoad;
    }
}
