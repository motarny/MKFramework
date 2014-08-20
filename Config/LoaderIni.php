<?php
namespace MKFramework\Config;

class LoaderIni extends Loader
{

    protected function parseConfig()
    {
        // TODO tymczasowo bardzo proste odczytywanie, bez zagniezdzania i bez dziedziczenia konfiguracji
        return parse_ini_file('../' . $this->_configLoad, false);
    }
}
