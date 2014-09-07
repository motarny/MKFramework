<?php
namespace MKFramework\Config;

/**
 * Klasa odczytująca konfigurację z pliku ini.
 * 
 * @author Marcin
 *
 */
class LoaderIni extends Loader
{

    protected function parseConfig()
    {
        // TODO tymczasowo bardzo proste odczytywanie, bez zagniezdzania i bez dziedziczenia konfiguracji
        return parse_ini_file('../' . $this->_configLoad, false);
    }
}
